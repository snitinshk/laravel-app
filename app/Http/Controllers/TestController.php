<?php

namespace App\Http\Controllers;


use App\Models\Audit;
use App\Models\Candidate;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\Haki;


use App\Models\CompanyScheduler;
use App\Models\Domains;
use App\Models\CompanyEmail;
use App\Models\Scheduler;


class TestController extends Controller
{

    public function test()
    {
        $list = array("cacode.co.uk", "potatos", "hunter.io", "google.com", "ckdash.net", "domains");

        foreach($list as $item){
            if(strlen($item) > 2){
                if(strpos($item, ".") !== false){


                }
            }

        }


    }





}
