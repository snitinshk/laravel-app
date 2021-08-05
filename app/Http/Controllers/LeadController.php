<?php

namespace App\Http\Controllers;

use App\Helper\Haki;
use App\Models\SearchScheduler;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LeadController extends Controller
{

    public function index(Request $request)
    {
        $current_user_id = Auth::id();
        $LinkedInCreds = DB::table("linked_in_creds")->where("user_id", $current_user_id)->first();
        if(strlen($LinkedInCreds->email) > 3){
            $LinkedInStatus = 1;
        }else{
            $LinkedInStatus = 0;
        }

        $UserInfo = User::where('id', $current_user_id)->first();
        if(strlen($UserInfo->stripe_sub_id) < 3) {
            return redirect("/setup");
        }else{
            return view('leads.search', ['LinkedInStatus' => $LinkedInStatus]);
        }
    }


    public function search(Request $request)
    {
        $current_user_id = Auth::id();
        $randTrackingID = Auth::id() . ":" . substr(str_shuffle(MD5(date("dhm"))), 0, 10);

        SearchScheduler::create([
            'user_id' => $current_user_id,
            'tracking_id' => $randTrackingID,
            'type' => 'candidate',
            'name' => $request->name,
            'url' => $request->url,
            'status' => 0,
            'scrape_status' => 0,
            'snov_status' => 0
        ]);

        return redirect(route("leads.list"));
    }


    public function list()
    {
        $current_user_id = Auth::id();
        $candidate_list = array();

        $QueuedJobs = SearchScheduler::where('status', 0)
                        ->where('user_id', $current_user_id)
                        ->where('type', 'candidate')
                        ->get();

        foreach($QueuedJobs as $q_job){
            array_push($candidate_list, array(0, $q_job->name, $q_job->created_at, "In Queue", ""));
        }

        $JobList = DB::select('SELECT query.id, search_schedulers.name, search_schedulers.created_at, search_schedulers.tracking_id, query.progress_status, query.search_results_num_scraped, query.scrape_candidates_num_scraped
                                FROM search_schedulers INNER JOIN query ON search_schedulers.tracking_id = query.tracking_id WHERE search_schedulers.type = "candidate" AND search_schedulers.user_id = ? ORDER BY search_schedulers.created_at DESC', [$current_user_id]);


        foreach($JobList as $job){
            array_push($candidate_list, array($job->id, $job->name, $job->created_at, Haki::getJobStatusByTID($job->tracking_id), $job->scrape_candidates_num_scraped . "/" . $job->search_results_num_scraped));
        }


        return view('leads.list', ['TableArray' => $candidate_list]);
    }


    public function view(Request $request, $id)
    {
        $Candidates = DB::table('candidate')
            ->where('query_id', '=', $id)
            ->get();

        return view('leads.view', ['Candidates' => $Candidates]);
    }


    public function export(Request $request, $id)
    {
        return Excel::download(new LeadExport($id), 'lead_export.xlsx');
    }


    public function delete(Request $request, $id)
    {
        $QueryInfo = DB::table('query')->where('id', '=', $id)->first();
        DB::table('search_schedulers')->where('tracking_id', '=', $QueryInfo->tracking_id)->delete();
        DB::table('query')->where('id', '=', $id)->delete();

        return redirect("/lead/list");
    }



}
