<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\CampaignSettings;
use App\Models\CampaignConfig;
use App\Models\CampaignTemplates;
use App\Models\CampaignFollowup;
use App\Models\Campaign;
use App\Models\UnsubcriptionMessage;
use Illuminate\Http\Request;
use Config;

class CampaignController extends Controller
{
    public function __construct(){
        // date_default_timezone_set("Asia/Kolkata");
    }
    
    public function unsubscribe(Request $request){
        $email = $request->input('email');
        if($email){
            $isSuccess = DB::table('email_contacts')->where('email_address', $email)
            ->update(['is_unsubscribed' => 1]);
            if($isSuccess){
                die('You have successfully unsubscribed, you can now close this tab.');
            }else{
                die('Invalid request!');
            }
        }else{
            die('Invalid request!');
        }
    }
    /**
     * List of users campaign
     */
    public function list(){
        $current_user_id = Auth::id();
        $campaign_list = DB::table('campaigns')->where('user_id',$current_user_id)->get();
        $data = [
            'campaign_list' => $campaign_list
        ];
        
        return view('campaign.list',$data);
    }
    public function view(Request $request){
        $current_user_id = Auth::id();
        $campaign_id = $request->id;
        $campaign_detail = DB::table('campaigns')->select('subject','email_group.name', 'template','campaign_name','campaign_config.email_from')
        ->where('campaigns.user_id',$current_user_id)
        ->leftJoin('campaign_config', 'campaign_config.id', '=', 'campaigns.email_from')
        ->leftJoin('email_group', 'campaigns.audience_email_group', '=', 'email_group.id')
        ->first();

        $campaign_followups = DB::table('campaign_followup')->where('campaign_id',$campaign_id)->get();
        $data = [
            'campaign_detail' => $campaign_detail,
            'campaign_followups' => $campaign_followups,
        ];
        // print_r($campaign_detail);die;
        return view('campaign.view',$data);
    }
    public function disable(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        if($type == 'campaign'){
            Campaign::findOrFail($id)->delete();
            return redirect(route('campaign.list'));
        }else if($type == 'template'){
            CampaignTemplates::findOrFail($id)->delete();
            return redirect(route('campaign.templates'));
        }
        
    }
    public function create(){
        $current_user_id = Auth::id();
        $email_group = DB::table('email_group')->get();
        
        $compaign_email_config = DB::table('campaign_config')->where('user_id',$current_user_id)->get();
        $compaign_templates = DB::table('campaign_templates')->where('user_id',$current_user_id)->get();
        $data = [
            'email_config' => $compaign_email_config,
            'compaign_templates' => $compaign_templates,
            'email_group' => $email_group
        ];
        return view('campaign.create',$data);
    }
    public function save_campaign(Request $request){
        $current_user_id = Auth::id();

        $validated = $request->validate([
            'subject' => "required|max:255",
            'template' => "required|max:255",
            'campaign_name' => "required|max:255",
        ]);
        $campaign = new Campaign();
        $campaign->user_id = $current_user_id;
        $campaign->campaign_name = $request->campaign_name;
        $campaign->email_from = $request->email_from;
        $campaign->subject = $request->subject;
        $campaign->template = $request->template;
        $campaign->audience_email_group = $request->selected_email_group;
        $campaign->save();

        $followups = isset($request->campaign)?$request->campaign:[];
        $campaign_followups = [];
        foreach ($followups as $key => $data) {
            $campaign_followups[$key]['campaign_id'] = $campaign->id;
            $campaign_followups[$key]['subject'] = $data['subject'];
            $campaign_followups[$key]['template'] = $data['template'];
            $campaign_followups[$key]['follow_up_days'] = isset($data['follow_up'])?$data['follow_up']:null;
            // $campaign_followups[$key]['sending_date'] = isset($data['follow_up'])?date('Y-m-d',strtotime('+'.$data['follow_up'].' days')):date('Y-m-d');
            $campaign_followups[$key]['created_at'] = date('Y-m-d H:i:s');
            $campaign_followups[$key]['updated_at'] = date('Y-m-d H:i:s');
        }
        if(!empty($campaign_followups)){
            CampaignFollowup::insert($campaign_followups);
        }
        
        return redirect(route('campaign.list'));

    }
    /**
     * Save email sending schedule
     */
    public function schedule(Request $request){
        $current_user_id = Auth::id();
        DB::table('compaign_schedulers')->where('user_id', $current_user_id)->delete();
        foreach ($request->user['campaign_schedule_days'] as $campaign) {

            $campaign_schedule = new CampaignSettings();
            $campaign_schedule->user_id = $current_user_id;
            $campaign_schedule->day = $campaign;
            $campaign_schedule->start_time = $request->user['campaign_schedule_time_start'];
            $campaign_schedule->end_time = $request->user['campaign_schedule_time_end'];
            $campaign_schedule->created_at = date('Y-m-d H:i:s',time());
            $campaign_schedule->save();
            
        }
        return redirect(route('campaign.settings'));
    }
    public function save_unsubscription_msg(Request $request){
        $current_user_id = Auth::id();
        $validated = $request->validate([
            'unsubscribe_text' => 'required',
        ]);
        
        if($request->usubcription_msg_id){
            $unsubscription_message = UnsubcriptionMessage::find($request->usubcription_msg_id);
        }else{
            $unsubscription_message = new UnsubcriptionMessage();
        }
        $unsubscription_message->user_id = $current_user_id;
        $unsubscription_message->message = $request->message;
        $resp = $unsubscription_message->save();
        
        return redirect(route('campaign.settings'));
    }
    /**
     * Save email config for the user
     */
    public function config(Request $request){

        $current_user_id = Auth::id();
        $validated = $request->validate([
            'host' => 'required|max:255',
            'port' => 'required|numeric|max:999',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'email_from' => 'required|max:255',
        ]);
        
        if($request->config_id){
            $campaign_config = CampaignConfig::find($request->config_id);
        }else{
            $campaign_config = new CampaignConfig();
        }

        $campaign_config->user_id = $current_user_id;
        $campaign_config->host = $request->host;
        $campaign_config->port = $request->port;
        $campaign_config->username = $request->username;
        $campaign_config->password = $request->password;
        $campaign_config->email_from = $request->email_from;
        $resp = $campaign_config->save();
        
        return redirect(route('campaign.settings'));
    }
    public function settings(){

        $current_user_id = Auth::id();
        /**
         *  Fetching current schedule
         */
        $days = array('Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday','Sunday');
        $compaign_schedule = DB::table('compaign_schedulers')->where('user_id',$current_user_id)->get();
        
        $selected_day = [];
        $campaign_start_time = date("H", strtotime("09:00")); // default start time
        $campaign_end_time = date("H", strtotime("05:00")); // default end time
        
        if(count($compaign_schedule)){
            foreach ($compaign_schedule as $key => $schedule) {
                $selected_day[] = $schedule->day;
            }
            $campaign_start_time = date("H", strtotime($compaign_schedule[0]->start_time));
            $campaign_end_time = date("H", strtotime($compaign_schedule[0]->end_time));
        }
        /**
         * Fetching Email Config
         */
        $compaign_email_config = DB::table('campaign_config')->where('user_id',$current_user_id)->first();

        /**
         * Fetching Unsubscription Message
         */
        $unsubcription_message_detail = DB::table('unsubcription_message')->where('user_id',$current_user_id)->first();

        $data = [
            'days' => $days,'campaign_start_time'=>$campaign_start_time,
            'campaign_end_time'=> $campaign_end_time,'selected_day'=> $selected_day,
            'compaign_email_config'=> $compaign_email_config,
            'unsubcription_message_detail'=> $unsubcription_message_detail,
            'default_unsubcription_message' => "|link|Click here|/link| if you don't want to hear from me again."
        ];
        return view('campaign.setting',$data);
    }
    public function manage_template(Request $request){

        $current_user_id = Auth::id();
        $validated = $request->validate([
            'template_name' => 'required|max:255',
            'template_subject' => 'required|max:255',
            'template' => 'required|max:255',
        ]);
        if($request->template_id){
            $campaign_template = CampaignTemplates::find($request->template_id);
        }else{
            $campaign_template = new CampaignTemplates();
        }
        
        $campaign_template->template_name = $request->template_name;
        $campaign_template->template_subject = $request->template_subject;
        $campaign_template->template = $request->template;
        $campaign_template->user_id = $current_user_id;
        $campaign_template->save();

        return redirect(route('campaign.templates'));

    }
    public function add_template(Request $request){
        $template_id = ($request->id)?$request->id:'';
        $current_user_id = Auth::id();
        $template = DB::table('campaign_templates')->where('id',$template_id)->where('user_id',$current_user_id)->first();
        $data = ['compaign_templates' => $template,'template_id'=>$template_id];
        return view('campaign.template-manage',$data);
    }
    public function templates(){
        $current_user_id = Auth::id();
        $compaign_templates = DB::table('campaign_templates')->where('user_id',$current_user_id)->get();
        $data = ['compaign_templates' => $compaign_templates];
        return view('campaign.template-list',$data);
    }

}
