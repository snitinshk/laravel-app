<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExecuteCampaignMailer;
use Config;

class ExecuteFollowup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * Find Campaign executed in last 10 days
         */
        $datebefore10days = date('Y-m-d',strtotime('-10 days'));
        $today_date = date('N');
        $timenow = date('H:i:s');
        $scheduled_now = DB::table('compaign_schedulers')
        ->select('campaigns.id as campaign_id','execution_date')
        ->leftJoin('campaigns', 'campaigns.user_id', '=', 'compaign_schedulers.user_id')
        ->where('start_time','<=',$timenow)->where('end_time','>=',$timenow)
        ->where('day',date('N'))->where('execution_date','>=',$datebefore10days)->get();

        $campaign_ids = [];
        foreach ($scheduled_now as $key => $scheduled) {
            $campaign_execution_date = strtotime($scheduled->execution_date);
            $now = time();
            $datediff = $now - $campaign_execution_date;
            $days_past = round($datediff / (60 * 60 * 24));
            if($days_past >= 1){
                $scheduled_followup = DB::table('campaign_followup as followup')
                ->select('followup.id as followup_id','followup.*','campaign_config.*','email_group.id as group_id','unsubcription_message.unsubscribe_text')
                ->selectRaw('IF(followup.subject is null,campaigns.subject,followup.subject) as subject')
                ->leftJoin('campaigns', 'campaigns.id', '=', 'followup.campaign_id')
                ->leftJoin('campaign_config', 'campaign_config.id', '=', 'campaigns.email_from')
                ->leftJoin('email_group', 'campaigns.audience_email_group', '=', 'email_group.id')
                ->leftJoin('unsubcription_message', 'campaigns.audience_email_group', '=', 'email_group.id')
                ->where(['campaign_id'=>$scheduled->campaign_id,'followup.is_executed'=>0])
                ->where('follow_up_days','<=',$days_past)
                ->first();
                
                if(!empty($scheduled_followup)){
                    $participants = DB::table('email_contacts')
                    ->where(['is_unsubscribed' => 0,'email_group_id'=>$scheduled_followup->group_id])->get();
        
        
                    foreach ($participants as $key => $participant) {
                        $campaign_detail = [];
                        $campaign_detail['campaign'] = $scheduled_followup;
                        $campaign_detail['participant'] = $participant;
                        $this->set_custom_mailer($scheduled_followup);
                        Mail::to($participant->email_address)->send(new ExecuteCampaignMailer($campaign_detail));   
                    }
                    
                    DB::table('campaign_followup')->where('id', $scheduled_followup->followup_id)
                    ->update(['execution_date'=>date('Y-m-d'),'is_executed' => 1]);
                }
            }

        }
        $this->info('Followup executed');
    }
    private function set_custom_mailer($campaign){
        Config::set('mail.mailers.smtp.host', $campaign->host);
        Config::set('mail.mailers.smtp.port', $campaign->port);
        Config::set('mail.mailers.smtp.username', $campaign->username);
        Config::set('mail.mailers.smtp.password', $campaign->password);
    }
}
