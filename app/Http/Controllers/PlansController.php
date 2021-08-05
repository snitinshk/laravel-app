<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Plans;

class PlansController extends Controller
{

    public function index()
    {
        // Get all from table
        $TableArray = Plans::where("status", ">", 0)->get();

        return view('plans.index', ['TableArray' => $TableArray]);
    }


    public function create()
    {
        return view('plans.create');
    }


    public function store(Request $request)
    {
        //User::create($FormData);
        Plans::create([
            'name' => $request->name,
            'lead_credits' => $request->lead_credits,
            'email_accounts' => $request->email_accounts,
            'frequency' => $request->frequency,
            'price' => $request->price,
            'stripe_id' => $request->stripe_price_id,
            'status' => 1
        ]);

        return redirect(route("plans"));
    }


    public function edit($id)
    {
        // Get all from User table where id = $id
        $PlanData = Plans::findOrFail($id);

        return view('plans.edit', ['PlanData' => $PlanData]);
    }


    public function update(Request $request, $id)
    {
        //Finds record using model, updates fields from Edit and saves
        $PlanData = Plans::findOrFail($id);
        $PlanData->name = $request->name;
        $PlanData->lead_credits = $request->lead_credits;
        $PlanData->email_accounts = $request->email_accounts;
        $PlanData->frequency = $request->frequency;
        $PlanData->price = $request->price;
        $PlanData->stripe_id = $request->stripe_price_id;
        $PlanData->save();

        return redirect(route("plans"));
    }


    public function delete(Request $request, $id)
    {
        //Finds record using model, updates fields from Edit and saves
        $PlanData = Plans::findOrFail($id)->delete();

        return redirect(route("plans"));
    }



    public function trial(Request $request){
        $SettingsInfo = DB::table("settings")->first();
        return view('plans.trial', ['SettingsInfo' => $SettingsInfo]);
    }


    public function trial_edit(Request $request){
        DB::table('settings')
            ->update([
                'trial_days' => $request->trial_days,
                'trial_credits' => $request->trial_credits
            ]);

        return redirect(route("plans"));
    }



}
