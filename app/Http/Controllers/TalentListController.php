<?php

namespace App\Http\Controllers;

use App\Models\SearchScheduler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helper\Haki;

class TalentListController extends Controller
{

    public function index()
    {
        $current_user_id = Auth::id();
        $candidate_list = array();

        $QueuedJobs = SearchScheduler::where('status', 0)->where('user_id', $current_user_id)->get();

        foreach($QueuedJobs as $q_job){
            array_push($candidate_list, array(0, $q_job->name, $q_job->created_at, "In Queue", ""));
        }

        $JobList = DB::select('SELECT query.id, search_schedulers.name, search_schedulers.created_at, query.progress_status, query.search_results_num_scraped, query.scrape_candidates_num_scraped
                                FROM search_schedulers INNER JOIN query ON search_schedulers.tracking_id = query.tracking_id WHERE search_schedulers.user_id = ? ORDER BY query.id DESC', [$current_user_id]);


        foreach($JobList as $job){
            array_push($candidate_list, array($job->id, $job->name, $job->created_at, Haki::getJobStatus($job->progress_status), $job->scrape_candidates_num_scraped . "/" . $job->search_results_num_scraped));
        }


        // State column names you want to display from the table
        $TableColumns = array('Search Name', 'Searched URL', 'Date Created', 'Status', 'Progress');

        // State what actions you want in the row
        $RowOptions = array(
            // Display Name, Icon Name, Slug
            //array("View", "search-alt", ""),
            array("View", "search", "")
        );

        return view('talentlist.index', ['TableColumns' => $TableColumns, 'TableArray' => $candidate_list, 'RowOptions' => $RowOptions]);
    }


    public function view(Request $request, $id)
    {
        $Candidates = DB::table('candidate')
            ->where('query_id', '=', $id)
            ->get();

        // State column names you want to display from the table
        $TableColumns = array('Full Name', 'Personal Email', 'Corporate Email', 'Current Job Title', 'Current Employer', 'Location', 'profile_url', 'Top Skill 1', 'Top Skill 2', 'Top Skill 3');

        return view('talentlist_view.index', ['TableColumns' => $TableColumns, 'TableArray' => $Candidates]);
    }


    public function store(Request $request)
    {
        //
    }


    public function download(Request $request, $id)
    {
        $candidates = DB::table('candidate')
            ->where('query_id', '=', $id)
            ->get();

        $filename = "export.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('full_name', 'current_job_title'));

        foreach($candidates as $row) {
            fputcsv($handle, array($row['full_name'], $row['current_job_title']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'export.csv', $headers);

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
