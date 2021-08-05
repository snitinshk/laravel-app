<?php

namespace App\Console\Commands;


use App\Helper\Haki;
use App\Models\Candidate;
use App\Models\LogData;
use App\Models\Queue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Scheduler;
use App\Models\Audit;
use App\Models\SearchScheduler;


class Snov extends Command
{

    protected $signature = 'snov:run';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $QueueActive = DB::table("queue")->where("status", ">", 0)->count();
        $NextQueueJob = DB::table("queue")->where("status", "=", 0)->orderBy("run_at", "asc")->first();

        // No Active Jobs, start next job
        if($QueueActive < 1){
            // Checks if datetime is <= now
            if(strtotime($NextQueueJob->run_at) <= strtotime(date("Y-m-d H:i:s"))) {
                // Marks as started
                $snov_token = Haki::snovGetAPIKey();
                $leads_count = 0;

                DB::table("search_schedulers")
                    ->where('tracking_id', $NextQueueJob->tracking_id)
                    ->update([
                        'snov_status' => 1
                    ]);

                DB::table("queue")->where("id", $NextQueueJob->id)->update([
                    'status' => 1
                ]);

                $CurrentQuery = DB::table('query')->where('tracking_id', $NextQueueJob->tracking_id)->first();

                $AllCandidates = DB::table('candidate')
                    ->where('query_id', $CurrentQuery->id)
                    //->where('status', "<", 1)
                    ->get();

                foreach($AllCandidates as $Candidate){
                    $url_filter = array("www.", "http://", "https://", "/");
                    $Can_CleanURL = str_replace($url_filter, "", $Candidate->current_employer_website);

                    if(strlen($Can_CleanURL) > 2){
                        $NameSplit = explode(" ", $Candidate->full_name);
                        $Can_FirstName = $NameSplit[0];
                        $Can_LastName = end($NameSplit);


                        // Post all leads to Snov
                        if($NextQueueJob->type == "SNOV_RUN_1"){
                            Haki::checkCredits($CurrentQuery->user_id, $NextQueueJob->tracking_id);
                            Haki::snovObtainEmail($snov_token, $Can_FirstName, $Can_LastName, $Can_CleanURL);
                            Haki::snovLogEntry($CurrentQuery->user_id);
                            $leads_count ++;
                            sleep(1);
                        }


                        // Collect all leads from Snov
                        if($NextQueueJob->type == "SNOV_RUN_2"){
                            $FindEmail = Haki::snovFindEmail($snov_token, $Can_FirstName, $Can_LastName, $Can_CleanURL);
                            if($FindEmail["success"] === true){
                                $CurrentCandidate = Candidate::where('id', $Candidate->id)->first();
                                $CurrentCandidate->corporate_email = $FindEmail["email"];
                                $CurrentCandidate->status = intval($FindEmail["status"]);
                                $CurrentCandidate->save();
                            }else{
                                // Failed to Obtain Email
                                $CurrentCandidate = Candidate::where('id', $Candidate->id)->first();
                                $CurrentCandidate->status = 1;
                                $CurrentCandidate->save();
                            }
                            sleep(1);
                        }

                    }
                }

                // Finished running through all Leads

                if($NextQueueJob->type == "SNOV_RUN_1"){
                    Audit::create([
                        'tracking_id' => $NextQueueJob->tracking_id,
                        'note' => "Snov first stage completed. Sent " . $leads_count . " leads"
                    ]);

                    // Clear current job
                    Queue::where("id", $NextQueueJob->id)->delete();

                    // Schedule next job in 2 hours
                    Queue::create([
                        'type' => "SNOV_RUN_2",
                        'query_id' => $CurrentQuery->id,
                        'tracking_id' => $NextQueueJob->tracking_id,
                        'run_at' => date("Y-m-d H:i:s", strtotime('+3 hours')),
                        'status' => 0,
                    ]);
                }


                if($NextQueueJob->type == "SNOV_RUN_2"){
                    Audit::create([
                        'tracking_id' => $NextQueueJob->tracking_id,
                        'note' => "Snov enrichment finished"
                    ]);

                    // Clear current job
                    Queue::where("id", $NextQueueJob->id)->delete();

                    DB::table("search_schedulers")
                        ->where('tracking_id', $NextQueueJob->tracking_id)
                        ->update([
                            'status' => 2,
                            'snov_status' => 2
                        ]);

                    Haki::emailCompletedJob($CurrentQuery->user_id, $NextQueueJob->tracking_id);
                }
            }
        }
    }

}
