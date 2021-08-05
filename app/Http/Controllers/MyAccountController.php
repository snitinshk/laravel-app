<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\LinkedInCreds;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Stripe\Exception\CardException;
use Stripe\Stripe;


class MyAccountController extends Controller
{

    public function index()
    {
        $current_user_id = Auth::id();

        // Get user data
        $UserData = DB::table("users")
                    ->select("users.first_name", "users.last_name", "users.email", "users.scrape_count as lead_credits_used", "users.stripe_trial", "users.scrape_limit", "users.plan_id", "clients.name as company_name", "plans.name as plan_name", "users.stripe_sub_start")
                    ->join("clients", "users.client_id", "=", "clients.id")
                    ->join("plans", "users.plan_id", "=", "plans.id")
                    ->where("users.id", $current_user_id)
                    ->first();

        $PlanData = DB::table("plans")
            ->where("id", $UserData->plan_id)
            ->first();

        return view('myaccount.index', ['UserData' => $UserData, 'PlanData' => $PlanData]);
    }


    public function update(Request $request)
    {
        $current_user_id = Auth::id();

        // Validate data, if criteria is not met it fails back to the page advising the user
        $request->validate([
            'linkedin_email' => 'required|string|max:255',
            'linkedin_password' => 'required|string|max:255'
        ]);

        $encrypt_password = Crypt::encryptString($request->linkedin_password);

        //Finds record using model, updates fields from Edit and saves
        $LinkedInData = LinkedInCreds::where('user_id', $current_user_id)->first();
        $LinkedInData->email = $request->linkedin_email;
        $LinkedInData->password = $encrypt_password;
        $LinkedInData->save();

        return redirect(route("myaccount"));
    }


    public function linkedin(Request $request)
    {
        $current_user_id = Auth::id();

        // Validate data, if criteria is not met it fails back to the page advising the user
        $request->validate([
            'linkedin_email' => 'required|string|max:255',
            'linkedin_password' => 'required|string|max:255'
        ]);

        $encrypt_password = Crypt::encryptString($request->linkedin_password);

        //Finds record using model, updates fields from Edit and saves
        $LinkedInData = LinkedInCreds::where('user_id', $current_user_id)->first();
        $LinkedInData->email = $request->linkedin_email;
        $LinkedInData->password = $encrypt_password;
        $LinkedInData->save();

        return redirect("/lead/search");
    }



    public function cancel_sub(Request $request){
        $current_user_id = Auth::id();
        $UserInfo = DB::table("users")->where("id", $current_user_id)->first();

        $stripe = new \Stripe\StripeClient(
            '*******'
        );

        $subscription = $stripe->subscriptions->cancel(
            $UserInfo->stripe_sub_id,
            []
        );

        DB::table('users')->where('id', $current_user_id)
            ->update([
                'plan_id' => null,
                'stripe_sub_id' => null,
                'stripe_sub_start' => null,
                'scrape_count' => 0,
                'scrape_limit' => 0,
            ]);

        return redirect("/setup");
    }



    public function signup(Request $request){
        return view('signup.index');
    }

    public function signup_save(Request $request){

        $CheckDB = User::where("email", "=", $request->email)->first();

        if($CheckDB == null){
            $CompanyInfo = Clients::create([
                'name' => $request->company_name,
                'contact_name' => $request->first_name . " " . $request->last_name,
                'email_address' => $request->email,
                'phone_number' => $request->phone_number,
                'status' => 2,
            ]);

            $UserInfo = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_code' => intval($request->country_code),
                'password' => Hash::make($request->password),
                'access' => 1,
                'ac_status' => 2,
                'client_id' => $CompanyInfo->id,
                'plan_id' => null,
                'device_id' => null,
                'device_last_check' => null,
                'stripe_customer_id' => "",
                'stripe_sub_id' => 0,
                'stripe_sub_start' => null,
                'stripe_trial' => 0,
                'scrape_count' => 0,
                'scrape_limit' => 0,
                'last_completed_job' => null
            ]);

            LinkedInCreds::create([
                'user_id' => $UserInfo->id,
                'email' => '',
                'password' => '',
            ]);

            return redirect("/");
        }

        return redirect("/signup");
    }



}
