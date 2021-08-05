<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TalentController extends Controller
{

    public function index()
    {
        return view('talent.index');
    }

}
