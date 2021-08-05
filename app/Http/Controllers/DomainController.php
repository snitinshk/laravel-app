<?php

namespace App\Http\Controllers;

use App\Helper\Haki;
use App\Models\Domains;
use App\Models\CompanyScheduler;
use App\Models\SearchScheduler;
use App\Models\Leads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DomainExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DomainController extends Controller
{

    public function index()
    {
        return view('domains.search');
    }


    public function search(Request $request)
    {
        $current_user_id = Auth::id();
        $randTrackingID = Auth::id() . ":" . substr(str_shuffle(MD5(date("dhm"))), 0, 10);

        // Reading CSV file
        $csv = array();
        if($_FILES['csv']['error'] == 0){
            $name = $_FILES['csv']['name'];
            $split_name = explode('.', $name);
            $ext = strtolower(end($split_name));
            $type = $_FILES['csv']['type'];
            $tmpName = $_FILES['csv']['tmp_name'];

            // check the file is a csv
            if($ext === 'csv'){
                if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                    $row = 0;

                    while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        if(strlen($data[0]) > 2){
                            if(strpos($data[0], ".") !== false){
                                array_push($csv, $data[0]);
                            }
                        }
                        $row++;
                    }
                    fclose($handle);


                    $NewJob = CompanyScheduler::create([
                        'user_id' => $current_user_id,
                        'tracking_id' => $randTrackingID,
                        'name' => $request->name,
                        'status' => 0,
                    ]);

                    foreach($csv as $Domain){
                        Domains::create([
                            'company_scheduler_id' => $NewJob->id,
                            'name' => null,
                            'domain' => $Domain,
                            'email_count' => null,
                        ]);
                    }
                }
            }
        }

        return redirect("/domain/list");
    }


    public function list()
    {
        $current_user_id = Auth::id();
        $Jobs = CompanyScheduler::where('user_id', $current_user_id)->get();
        $JobsArray = array();

        foreach($Jobs as $Job){
            switch($Job->status){
                case 0:
                    $job_status = "In Queue";
                    break;
                case 1:
                    $job_status = "In Progress";
                    break;
                case 2:
                    $job_status = "Completed";
                    break;
                case 3:
                    $job_status = "Part completed, no remaining credits";
                    break;
            }

            array_push($JobsArray, array(
                $Job->name,
                $Job->created_at,
                Domains::where("company_scheduler_id", $Job->id)->count(),
                $job_status,
                $Job->id
            ));
        }

        return view('domains.list', ['TableArray' => $JobsArray]);
    }


    public function view(Request $request, $id)
    {
        $CompanyEmails = DB::table('companies')
            ->select("companies.name", "companies.domain", "company_emails.*")
            ->join("company_emails", "companies.id", "=", "company_emails.company_id")
            ->where('companies.company_scheduler_id', '=', $id)
            ->get();

        return view('domains.view', ['CompanyEmails' => $CompanyEmails]);
    }


    public function export(Request $request, $id)
    {
        return Excel::download(new DomainExport($id), 'domain_email_export.xlsx');
    }


    public function delete(Request $request, $id)
    {
        DB::table('company_schedulers')->where('id', '=', $id)->delete();

        return redirect("/domain/list");
    }



}
