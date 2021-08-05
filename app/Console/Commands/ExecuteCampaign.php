<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use App\Mail\ExecuteCampaignMailer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Config;

class ExecuteCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:campaign';

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
         * Find users having sending window scheduled for this time
         */
        $today_date = date('N');
        $timenow = date('H:i:s');
        $scheduled_now = DB::table('compaign_schedulers')->select('user_id')
        ->where('start_time','<=',$timenow)->where('end_time','>=',$timenow)->where('day',date('N'))->get();
        
        $user_ids = [];
        foreach ($scheduled_now as $key => $scheduled) {
            $user_ids[] = $scheduled->user_id;
        }
        if(empty($user_ids)){
            $this->info('Nothing in sending window');
        }
        /**
         * Fetch campaign scheduled for today
         */
        $campaign_list = DB::table('campaigns')
        ->select('campaigns.id as campaign_id','campaigns.*','campaign_config.*','email_group.id as group_id','unsubcription_message.unsubscribe_text')
        ->leftJoin('campaign_config', 'campaign_config.id', '=', 'campaigns.email_from')
        ->leftJoin('email_group', 'campaigns.audience_email_group', '=', 'email_group.id')
        ->leftJoin('unsubcription_message', 'campaigns.audience_email_group', '=', 'email_group.id')
        ->whereRaw('campaigns.user_id IN ('.implode(',',$user_ids).')')
        ->where(['status'=>'1','is_executed'=>0])->get();

        foreach ($campaign_list as $key => $campaign) {
            $participants = DB::table('email_contacts')
            ->where(['is_unsubscribed' => 0,'email_group_id'=>$campaign->group_id])->get();
            foreach ($participants as $key => $participant) {
                $campaign_detail = [];
                $campaign_detail['campaign'] = $campaign;
                $campaign_detail['participant'] = $participant;
                $this->set_custom_mailer($campaign);
                Mail::to($participant->email_address)->send(new ExecuteCampaignMailer($campaign_detail));   
            }
            DB::table('campaigns')->where('id', $campaign->campaign_id)
            ->update(['execution_date'=>date('Y-m-d'),'is_executed' => 1]);
        }
        $this->info('Campaign executed');
    }
    private function set_custom_mailer($campaign){
        Config::set('mail.mailers.smtp.host', $campaign->host);
        Config::set('mail.mailers.smtp.port', $campaign->port);
        Config::set('mail.mailers.smtp.username', $campaign->username);
        Config::set('mail.mailers.smtp.password', $campaign->password);
    }
}
