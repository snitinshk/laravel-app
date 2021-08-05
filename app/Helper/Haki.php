<?php

namespace App\Helper;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserAccess;
use App\Models\UserStatus;
use App\Models\Clients;
use App\Models\Plans;
use App\Models\LogData;

use App\Mail\JobCompleted;
use Illuminate\Support\Facades\Mail;


class Haki{

    public static function isUserAdmin(){
        $current_user_id = Auth::id();
        $UserData = User::findOrFail($current_user_id);
        if($UserData->access > 1){
            return true;
        }else{
            return false;
        }
    }

    public static function getUserAccess($access_id){
        $UserAccess = UserAccess::findOrFail($access_id);
        return $UserAccess->name;
    }

    public static function getUserStatus($status_id){
        $UserStatus = UserStatus::findOrFail($status_id);
        return $UserStatus->name;
    }

    public static function getUserClient($client_id){
        $UserClient = Clients::findOrFail($client_id);
        return $UserClient->name;
    }

    public static function getUserPlan($plan_id){
        if($plan_id == null){
            return "None";
        }else{
            $UserPlan = Plans::findOrFail($plan_id);
            return $UserPlan->name;
        }
    }

    public static function getActiveUsersOnPlan($plan_id){
        return DB::table("users")
                    ->where("plan_id", $plan_id)
                    ->count();
    }


    public static function emailCompletedJob($user_id, $tracking_id){
        $UserData = DB::table("users")
            ->where("id", intval($user_id))
            ->first();
        $JobData = DB::table("search_schedulers")->where("tracking_id", "=", $tracking_id)->first();

        Mail::to($UserData->email)
            ->send(new JobCompleted($UserData->first_name, $JobData->name));
    }

    public static function getNameByUserID($id){
        $UserData = DB::table("users")
            ->where("id", intval($id))
            ->first();
        return $UserData->first_name . " " . $UserData->last_name;
    }

    public static function getCountryByID($id){
        $UserData = DB::table("countries")
            ->where("id", intval($id))
            ->first();
        return $UserData->name;
    }


    public static function formatDateTime($datetime){
        if(strlen($datetime)>3){
            return substr($datetime,8,2) . "/" . substr($datetime,5,2) . "/" . substr($datetime,0,4) . substr($datetime,10,6);
        }else{
            return "";
        }
    }

    public static function getJobStatusByTID($tracking_id){
        $Job = DB::table("search_schedulers")->where("tracking_id", $tracking_id)->first();

        // In Queue
        if($Job->status == 0){
            return "Job in queue";
        }

        if($Job->status == 1){
            // Scraper Started

            $Query = DB::table("query")->where("tracking_id", $tracking_id)->first();

            if($Job->scrape_status < 2){
                switch($Query->progress_status){
                    case "STARTING_UP":
                        return "Running...";
                    case "STARTED_COLLECTING_SEARCH_RESULS":
                        return "Running...";
                    case "STARTED_SCRAPING_CANDIDATES":
                        return "Running...";
                    case "STARTED_SCRAPING":
                        return "Running...";
                    case "COMPLETED_SCRAPING_CANDIDATES":
                        return "Collected leads, processing..";
                    default:
                        return "Error";
                }
            }else{
                // Snov Started
                if($Job->snov_status > 2){
                    return "Enrichment stopped, no available credits";
                }else{
                    if($Job->snov_status > 0){
                        return "Enriching emails..";
                    }else{
                        return "Waiting to enrich emails..";
                    }
                }
            }
        }

        // Everything finished
        if($Job->status == 2){
            return "Completed";
        }



    }

    public static function getJobStatus($status){
        switch($status){
            case "STARTING_UP":
                return "Running...";
            case "STARTED_COLLECTING_SEARCH_RESULS":
                return "Running...";
            case "STARTED_SCRAPING_CANDIDATES":
                return "Running...";
            case "STARTED_SCRAPING":
                return "Running...";
            case "COMPLETED_SCRAPING_CANDIDATES":
                return "Completed";
            default:
                return "Error";
        }
    }

    public static function getCompanyJobStatus($status){
        switch($status){
            case "STARTING_UP":
                return "Running...";
            case "STARTED_COLLECTING_SEARCH_RESULS":
                return "Running...";
            case "STARTED_SCRAPING_EMPLOYERS":
                return "Running...";
            case "STARTED_SCRAPING":
                return "Running...";
            case "COMPLETED_SCRAPING_EMPLOYERS":
                return "Completed";
            default:
                return "Error";
        }
    }


    public static function snovGetAPIKey(){
        $params = [
            'grant_type'    => 'client_credentials',
            'client_id'     => '#',
            'client_secret' => '#'
        ];
        $options = [
            CURLOPT_URL            => 'https://api.snov.io/v1/oauth/access_token',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $res['access_token'];
    }


    public static function snovFindEmail($token, $first_name, $last_name, $url){
        $params = [
            'access_token' => $token,
            'domain'       => $url,
            'firstName'    => $first_name,
            'lastName'     => $last_name
        ];

        $options = [
            CURLOPT_URL            => 'https://api.snov.io/v1/get-emails-from-names',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ];

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);


        if($res["success"] === false){
            return array("success" => false);
        }else{
            if($res["status"]["identifier"] == "complete"){
                if(count($res["data"]["emails"]) > 0){
                    if($res["data"]["emails"][0]["emailStatus"] == "valid"){ $e_status = 2; }else{ $e_status = 1; }
                    return array("success" => true, "email" => $res["data"]["emails"][0]["email"], "status" => $e_status);
                }else{
                    return array("success" => false);
                }
            }else {
                return array("success" => false);
            }
        }
    }


    public static function snovObtainEmail($token, $first_name, $last_name, $url){
        $params = [
            'access_token' => $token,
            'domain'       => $url,
            'firstName'    => $first_name,
            'lastName'     => $last_name
        ];
        $options = [
            CURLOPT_URL            => 'https://api.snov.io/v1/add-names-to-find-emails',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $res["success"];
    }


    public static function snovGetCompanyInfo($domain_name){
        $snov_token = Haki::snovGetAPIKey();

        $params = [
            'access_token' => $snov_token,
            'domain'       => $domain_name,
            'type'         => 'all',
            'limit'        => 100,
            'lastId'       => 0
        ];

        $params = http_build_query($params);
        $options = [
            CURLOPT_URL            => 'https://api.snov.io/v2/domain-emails-with-info?'.$params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ];

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if($res["success"] === false){
            return array("success" => false);
        }else{
            $EmailsArray = array();

            $all_emails = $res["emails"];

            foreach($all_emails as $email){
                array_push($EmailsArray, array(
                    "email" => $email["email"],
                    "type" => $email["type"],
                    "status" => $email["status"],
                    "first_name" => isset($email["firstName"]) ? $email["firstName"] : "",
                    "last_name" => isset($email["lastName"]) ? $email["lastName"] : "",
                    "position" => isset($email["position"]) ? $email["position"] : "",
                    "source" => isset($email["sourcePage"]) ? $email["sourcePage"] : "",
                ));
            }

            $CompanyData = array(
                "name" => $res["companyName"],
                "email_count" => $res["result"],
                "emails" => $EmailsArray
            );

            return array("success" => true, "data" => $CompanyData);
        }
    }


    public static function checkCredits($user_id, $tracking_id){
        $UserCount = DB::table("users")->where("id", $user_id)->first();
        if($UserCount->scrape_count >= $UserCount->scrape_limit){
            Audit::create([
                'tracking_id' => $tracking_id,
                'note' => "User ran out of credits. Snov enrichment stopped. Clearing Scheduler"
            ]);

            DB::table("search_schedulers")
                ->where('tracking_id', $tracking_id)
                ->update([
                    'status' => 1,
                    'snov_status' => 3
                ]);

            DB::table("queue")->where("tracking_id", "=", $tracking_id)->delete();
            die;
        }
    }


    public static function snovLogEntry($user_id){
        $CurrentCandidate = User::where('id', $user_id)->first();
        $CurrentCandidate->scrape_count = intval($CurrentCandidate->scrape_count) + 1;
        $CurrentCandidate->save();
    }



    public static function getSelectCountries(){
        $string_builder = "";
        $Countries = DB::table("countries")->get();
        foreach($Countries as $Country){
            $string_builder .= "<option value='{$Country->id}'>{$Country->name}</option>";
        }
        return $string_builder;
    }



}
