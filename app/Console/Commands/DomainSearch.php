<?php

namespace App\Console\Commands;


use App\Helper\Haki;
use App\Models\Candidate;
use App\Models\CompanyEmail;
use App\Models\CompanyScheduler;
use App\Models\Domains;
use App\Models\LogData;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Scheduler;
use App\Models\Audit;
use App\Models\SearchScheduler;

class DomainSearch extends Command
{

    protected $signature = 'DomainSearch:run';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $DomainJob = CompanyScheduler::where("status", 0)->first();
        if($DomainJob != null){
            Audit::create([
                'tracking_id' => $DomainJob->tracking_id,
                'note' => "Domain Search started"
            ]);

            CompanyScheduler::where("id", $DomainJob->id)->update([ 'status' => 1 ]);
            $CurrentCompanyJob = CompanyScheduler::where("id", $DomainJob->id)->first();

            $Domains = Domains::where("company_scheduler_id", intval($DomainJob->id))->get();

            foreach($Domains as $Domain){
                $UserCount = DB::table("users")->where("id", $CurrentCompanyJob->user_id)->first();
                if($UserCount->scrape_count >= $UserCount->scrape_limit){
                    Audit::create([
                        'tracking_id' => $CurrentCompanyJob->tracking_id,
                        'note' => "User ran out of credits. Snov enrichment stopped. Clearing Scheduler"
                    ]);

                    DB::table("company_schedulers")
                        ->where('tracking_id', $CurrentCompanyJob->tracking_id)
                        ->update([
                            'status' => 3,
                        ]);

                    die;
                }

                $SnovCompanyData = Haki::snovGetCompanyInfo($Domain->domain);

                if($SnovCompanyData["success"] == false){
                    Domains::where('id', $Domain->id)->update([
                        'name' => "No results found",
                        'email_count' => 0
                    ]);
                }else{
                    foreach($SnovCompanyData["data"]["emails"] as $CompanyEmail){
                        CompanyEmail::create([
                            'company_id' => $Domain->id,
                            'email' => $CompanyEmail["email"],
                            'type' => $CompanyEmail["type"],
                            'status' => $CompanyEmail["status"],
                            'first_name' => $CompanyEmail["first_name"],
                            'last_name' => $CompanyEmail["last_name"],
                            'position' => $CompanyEmail["position"],
                            'source' => $CompanyEmail["source"],
                        ]);
                    }

                    // Finished with all emails
                    Domains::where('id', $Domain->id)->update([
                        'name' => $SnovCompanyData["data"]["name"],
                        'email_count' => intval($SnovCompanyData["data"]["email_count"])
                    ]);
                }
                // Finished with this Domain
                sleep(2);
            }

            // Finished all Domains
            CompanyScheduler::where('id', intval($DomainJob->id))->update(['status' => 2]);
            $CountCredits = Domains::where("company_scheduler_id", intval($DomainJob->id))->sum("email_count");
            $used_credits = round($CountCredits / 10,0);

            $CurrentCandidate = User::where('id', $DomainJob->user_id)->first();
            $CurrentCandidate->scrape_count = intval($CurrentCandidate->scrape_count) + intval($used_credits);
            $CurrentCandidate->save();

        }
    }
}
