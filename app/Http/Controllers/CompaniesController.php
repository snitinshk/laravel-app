<?php

namespace App\Http\Controllers;

use App\Helper\Haki;
use App\Models\SearchScheduler;
use App\Models\Leads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CompanyExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{

    public function index()
    {
        return view('companies.search');
    }


    public function search(Request $request)
    {
        $current_user_id = Auth::id();
        $randTrackingID = Auth::id() . ":" . substr(str_shuffle(MD5(date("dhm"))), 0, 10);

        SearchScheduler::create([
            'user_id' => $current_user_id,
            'tracking_id' => $randTrackingID,
            'type' => 'employer',
            'name' => $request->name,
            'url' => $request->url,
            'status' => 0,
            'scrape_status' => 0,
            'snov_status' => 2
        ]);

        return redirect(route("company.list"));
    }


    public function list()
    {
        $current_user_id = Auth::id();
        $employer_list = array();

        $QueuedJobs = SearchScheduler::where('status', 0)
            ->where('user_id', $current_user_id)
            ->where('type', 'employer')
            ->get();

        foreach($QueuedJobs as $q_job){
            array_push($employer_list, array(0, $q_job->name, $q_job->created_at, "In Queue", ""));
        }

        $JobList = DB::select('SELECT query.id, search_schedulers.name, search_schedulers.created_at, query.progress_status, query.search_results_num_scraped, query.scrape_candidates_num_scraped
                                FROM search_schedulers INNER JOIN query ON search_schedulers.tracking_id = query.tracking_id WHERE search_schedulers.type = "employer" AND search_schedulers.user_id = ? ORDER BY search_schedulers.created_at DESC', [$current_user_id]);


        foreach($JobList as $job){
            array_push($employer_list, array($job->id, $job->name, $job->created_at, Haki::getCompanyJobStatus($job->progress_status), $job->scrape_candidates_num_scraped . "/" . $job->search_results_num_scraped));
        }

        return view('companies.list', ['TableArray' => $employer_list]);
    }


    public function view(Request $request, $id)
    {
        $Companies = DB::table('employer')
            ->where('query_id', '=', $id)
            ->get();

        return view('companies.view', ['Companies' => $Companies]);
    }


    public function export(Request $request, $id)
    {
        return Excel::download(new CompanyExport($id), 'company_export.xlsx');
    }


    public function delete(Request $request, $id)
    {
        DB::table('query')->where('id', '=', $id)->delete();

        return redirect("/company/list");
    }



}
