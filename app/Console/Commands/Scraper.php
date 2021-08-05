<?php

namespace App\Console\Commands;


use App\Models\Audit;
use App\Models\CompanyScheduler;
use App\Models\LogData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Scheduler;
use App\Models\Queue;
use App\Models\LinkedInCreds;
use App\Models\SearchScheduler;
use App\Helper\Haki;


class Scraper extends Command
{

    protected $signature = 'scraper:run';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        // Checks for completed candidate jobs and earmarks for the Snov Command to pickup
        $data = DB::table("search_schedulers")
            ->select("search_schedulers.tracking_id", "search_schedulers.user_id", "query.id as query_id")
            ->join("query", "search_schedulers.tracking_id", "=", "query.tracking_id")
            ->where("query.progress_status", "=", "COMPLETED_SCRAPING_CANDIDATES")
            ->where("search_schedulers.type", "=", "candidate")
            ->where("search_schedulers.scrape_status", "<", 2)
            ->where("search_schedulers.snov_status", "<", 1)->first();

        if($data != NULL){
            // Moves Job to next stage
            DB::table("search_schedulers")->where("tracking_id", $data->tracking_id)
                ->update(['scrape_status' => 2]);

            Queue::create([
                'type' => "SNOV_RUN_1",
                'query_id' => $data->query_id,
                'tracking_id' => $data->tracking_id,
                'run_at' => NOW(),
                'status' => 0,
            ]);

            DB::table("users")->where("id", intval($data->user_id))
                ->update(['last_completed_job' => NOW()]);

            Audit::create([
                'tracking_id' => $data->tracking_id,
                'note' => "Added to Scheduler for Snov Run 1"
            ]);
        }



        // Checks for completed Company jobs and marks as completed
        $Employer_Searches = DB::table("search_schedulers")
            ->select("search_schedulers.user_id", "search_schedulers.tracking_id", "search_schedulers.name")
            ->join("query", "search_schedulers.tracking_id", "=", "query.tracking_id")
            ->where("search_schedulers.type", "=", "employer")
            ->where("search_schedulers.status", "<", 2)
            ->where("query.progress_status", "=", "COMPLETED_SCRAPING_EMPLOYERS")->get();

        foreach($Employer_Searches as $search){
            DB::table("search_schedulers")->where("tracking_id", "=", $search->tracking_id)
                ->update(['status' => 2, 'scrape_status' => 2]);

            DB::table("users")->where("id", intval($search->user_id))
                ->update(['last_completed_job' => NOW()]);

            Haki::emailCompletedJob($search->user_id, $search->tracking_id);
        }


    }
}
