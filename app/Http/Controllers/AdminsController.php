<?php

namespace App\Http\Controllers;

use App\Helper\Haki;
use App\Models\SearchScheduler;
use Illuminate\Http\Request;
use App\Helper\FormBuilder;
use App\Models\User;
use App\Models\LinkedInCreds;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller
{

    public function index()
    {
        // Get all from User table
        $TableArray = User::where('access', 2)
            ->orderBy('first_name', 'asc')
            ->get();

        return view('admins.index', ['TableArray' => $TableArray]);
    }


    public function create(Request $request)
    {
        return view('admins.create');
    }


    public function store(Request $request)
    {
        // Validate data, if criteria is not met it fails back to the page advising the user
        $FormData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $UserInfo = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => "",
            'country_code' => 287,
            'password' => Hash::make($request->password),
            'access' => 2,
            'ac_status' => 2,
            'client_id' => 0,
            'plan_id' => 12,
            'device_id' => substr($request->email,0, 3) . substr(md5(date("dmyhis") . rand(100,999) . "ECdt-5k!OPC1tv"), 16),
            'device_last_check' => null,
            'stripe_customer_id' => "",
            'stripe_sub_id' => 0,
            'stripe_sub_start' => null,
            'stripe_trial' => 0,
            'scrape_count' => 0,
            'scrape_limit' => 99999,
            'last_completed_job' => null
        ]);

        LinkedInCreds::create([
            'user_id' => $UserInfo->id,
            'email' => '',
            'password' => '',
        ]);

        return redirect(route("admins"));
    }


    public function edit($id)
    {
        // Get all from User table where id = $id
        $UserData = User::findOrFail($id);

        return view('admins.edit', ['UserData' => $UserData]);
    }


    public function update(Request $request, $id)
    {
        // Validate data, if criteria is not met it fails back to the page advising the user
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        //Finds record using model, updates fields from Edit and saves
        $UserData = User::findOrFail($id);
        $UserData->first_name = $request->first_name;
        $UserData->last_name = $request->last_name;
        $UserData->email = $request->email;
        $UserData->save();

        return redirect(route("admins"));
    }


    public function enable(Request $request, $id)
    {
        //Finds record using model, updates fields from Edit and saves
        $UserData = User::findOrFail($id);
        $UserData->ac_status = 2;
        $UserData->save();

        return redirect(route("admins"));
    }


    public function disable(Request $request, $id)
    {
        //Finds record using model, updates fields from Edit and saves
        $UserData = User::findOrFail($id)->delete();

        return redirect(route("admins"));
    }




    public function leadJobList(Request $request){
        $candidate_list = array();

        $QueuedJobs = SearchScheduler::where('status', 0)
            ->where('type', 'candidate')
            ->get();

        foreach($QueuedJobs as $q_job){
            array_push($candidate_list, array(0, $q_job->name, $q_job->created_at, "In Queue", "", $q_job->user_id));
        }

        $JobList = DB::select('SELECT query.id,
                                       search_schedulers.name,
                                       search_schedulers.created_at,
                                       search_schedulers.tracking_id,
                                       query.progress_status,
                                       query.search_results_num_scraped,
                                       query.scrape_candidates_num_scraped,
                                        query.user_id
                                FROM search_schedulers
                                    INNER JOIN query ON search_schedulers.tracking_id = query.tracking_id
                                    INNER JOIN users ON query.user_id = users.id
                                WHERE search_schedulers.type = "candidate"
                                ORDER BY search_schedulers.created_at DESC');


        foreach($JobList as $job){
            array_push($candidate_list, array($job->id, $job->name, $job->created_at, Haki::getJobStatusByTID($job->tracking_id), $job->scrape_candidates_num_scraped . "/" . $job->search_results_num_scraped, $job->user_id));
        }


        return view('admins.lead_list', ['TableArray' => $candidate_list]);
    }

    public function queueList(Request $request){
        $TableArray = DB::table("queue")
            ->select("users.first_name", "users.last_name", "search_schedulers.name", "queue.type", "queue.run_at", "queue.status")
            ->join("query", "queue.tracking_id", "=", "query.tracking_id")
            ->join("users", "query.user_id", "=", "users.id")
            ->join("search_schedulers", "queue.tracking_id", "=", "search_schedulers.tracking_id")
            ->orderBy('queue.created_at', 'asc')
            ->get();

        return view('admins.queue', ['TableArray' => $TableArray]);
    }


    public function auditList(Request $request){
        $TableArray = DB::table("audit")
            ->select("users.first_name", "users.last_name", "search_schedulers.name", "audit.note", "audit.created_at")
            ->join("query", "audit.tracking_id", "=", "query.tracking_id")
            ->join("users", "query.user_id", "=", "users.id")
            ->join("search_schedulers", "audit.tracking_id", "=", "search_schedulers.tracking_id")
            ->orderBy('audit.created_at', 'asc')
            ->get();

        return view('admins.audit', ['TableArray' => $TableArray]);
    }



}
