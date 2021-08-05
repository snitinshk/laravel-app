<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExecuteCampaignMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($campaign_detail)
    {
        // echo '<pre>';
        // print_r($campaign_detail['participant']);die('voila');
        
        $this->campaign = $campaign_detail['campaign'];
        $this->participant_detail = $campaign_detail['participant'];

    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        $template = $this->parse_template($this->campaign->template,$this->participant_detail);
        $unsubscribe_link = $this->parse_unsubscription($this->campaign->unsubscribe_text,$this->participant_detail->email_address);
        
        return $this->from($this->campaign->email_from)
        ->subject($this->campaign->subject)->view('emails.execute')
        ->with(['template' => $template,'unsubscribe_link'=>$unsubscribe_link]);
    }
    private function parse_unsubscription($unsubscribe_text,$email){
        $unsubscribe_text = ($unsubscribe_text)?$unsubscribe_text:"|link|Click here|/link| if you don't want to hear from me again.";
        $link_placeholder = '|link|Click here|/link|';
        $unsubscribe_link = '<a href="'.route('campaign.unsubscribe').'?email='.$email.'"> Click here</a>';
        return str_replace($link_placeholder,$unsubscribe_link,$unsubscribe_text);
    }
    private function parse_template($template,$participant){

        $first_name = $participant->first_name;
        $last_name = $participant->last_name;
        $email = $participant->email_address;
        $company = $participant->company;
        $job_title = $participant->job_title;

        $pattern = '/\|(.*?)\|/';
        preg_match_all($pattern, $template, $matches);
        foreach ($matches[0] as $key => $value) {
            if(strpos($value, 'first_name') !== false){
                if(!empty($first_name)){
                    $template = str_replace($value,$first_name,$template);
                }else{
                    $template = str_replace($value,explode(':',trim($value,'|'))[1],$template);
                }
            }
            if(strpos($value, 'last_name') !== false){
                if(!empty($last_name)){
                    $template = str_replace($value,$last_name,$template);
                }else{
                    $template = str_replace($value,explode(':',trim($value,'|'))[1],$template);
                }
            }
            if(strpos($value, 'full_name') !== false){
                if(!empty($last_name) && !empty($first_name)){
                    $full_name = $first_name.' '.$last_name;
                    $template = str_replace($value,$full_name,$template);
                }else{
                    $template = str_replace($value,explode(':',trim($value,'|'))[1],$template);
                }
            }
            if(strpos($value, 'company') !== false){
                if(!empty($company)){
                    $template = str_replace($value,$company,$template);
                }else{
                    $template = str_replace($value,explode(':',trim($value,'|'))[1],$template);
                }
            }
            if(strpos($value, 'job_title') !== false){
                if(!empty($email)){
                    $template = str_replace($value,$job_title,$template);
                }else{
                    $template = str_replace($value,explode(':',trim($value,'|'))[1],$template);
                }
            }
            if(strpos($value, 'email') !== false){
                if(!empty($email)){
                    $template = str_replace($value,$email,$template);
                }else{
                    $template = str_replace($value,explode(':',trim($value,'|'))[1],$template);
                }
            }
        }
        return $template;
    }
}
