<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\LinkedInCreds;
use App\Models\SearchScheduler;

class SchedulerController extends Controller
{

    public function index(Request $request){
        $results = DB::select("SELECT search_schedulers.url, search_schedulers.tracking_id, users.id FROM search_schedulers INNER JOIN users ON search_schedulers.user_id = users.id
                    WHERE search_schedulers.status = 0 AND users.device_id = ? LIMIT 1", [$_POST["did"]]);

        if($results == null){
            echo json_encode(array(
                "return" => false
            ));
        }else{
            $UserData = DB::table("users")->where("id", intval($results[0]->id))->first();
            $mins_since_last_job = round(abs(strtotime(date("Y-m-d H:i:s")) - strtotime($UserData->last_completed_job)) / 60,0);

            if($mins_since_last_job >= intval(env("JOB_WAIT_MINS"))){
                $LinkedInData = LinkedInCreds::where('user_id', $results[0]->id)->first();
                $CurrentJob = SearchScheduler::where('tracking_id', $results[0]->tracking_id);
                DB::table('search_schedulers')
                    ->where('tracking_id', $results[0]->tracking_id)
                    ->update(['status' => 1, 'scrape_status' => 1]);

                DB::table("users")->where("id", intval($results[0]->id))
                    ->update(['last_completed_job' => NOW()]);

                echo json_encode(array(
                    "return" => true,
                    "url" => $results[0]->url,
                    "email" => $LinkedInData->email,
                    "password" => Crypt::decryptString($LinkedInData->password),
                    "tracking_id" => $results[0]->tracking_id,
                    "user_id" => $results[0]->id,
                ));
            }
        }

    }


    public function confirm(Request $request){
        $results = DB::select("SELECT users.id FROM users WHERE users.device_id = ?", [$_GET["did"]]);
        if($results == null){
            echo json_encode(array(
                "return" => false
            ));
        }else{
            echo json_encode(array(
                "return" => true
            ));
        }
    }


    public function appdash(Request $request){
        $results = DB::table("users")->where("device_id", $_GET["did"])->first();
        return view('appdash.index', ['user_name' => $results->first_name]);
    }


}
