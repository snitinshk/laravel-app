<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Stripe\Exception\CardException;
use Stripe\Stripe;
use App\Models\Payments;


class SetupController extends Controller
{

    public function index(Request $request){
        $current_user_id = Auth::id();
        $UserInfo = DB::table("users")->where("id", $current_user_id)->first();

        if(strlen($UserInfo->stripe_sub_id) > 3){
            return redirect("/");
        }else{
            $SettingsInfo = DB::table("settings")->first();
            $MonthlyPlans = DB::table("plans")->where("frequency", "monthly")->where("status", ">", 0)->get();
            $AnnualPlans = DB::table("plans")->where("frequency", "annually")->where("status", ">", 0)->get();

            return view("setup.index", ["MonthlyPlans" => $MonthlyPlans, "AnnualPlans" => $AnnualPlans, "TrialDays" => $SettingsInfo->trial_days, "Failed" => ""]);
        }
    }


    public function app(){
        $current_user_id = Auth::id();
        $UserInfo = DB::table("users")->where("id", $current_user_id)->first();
        $SettingsInfo = DB::table("settings")->first();

        return view("setup.app", ["UserInfo" => $UserInfo, 'SettingsInfo' => $SettingsInfo]);
    }


    public function first_subscription(Request $request){
        $sub_successful = false;
        $current_user_id = Auth::id();
        $PlanInfo = DB::table("plans")->where("id", intval($request->form_plan_id))->first();
        $UserInfo = DB::table("users")->where("id", $current_user_id)->first();
        $SettingsInfo = DB::table("settings")->first();

        if($PlanInfo == null){
            var_dump($PlanInfo);
            die;
        }


        \Stripe\Stripe::setApiKey("********");
        $stripe_customer_id = "";

        if(strlen($UserInfo->stripe_customer_id) < 5){
            // Add customer to stripe
            try {
                $customer = \Stripe\Customer::create(array(
                    'name' => $UserInfo->first_name . " " . $UserInfo->last_name,
                    'email' => $UserInfo->email,
                    'source'  => $request->stripeToken
                ));

                DB::table('users')->where('id', $current_user_id)
                    ->update(['stripe_customer_id' => $customer->id]);
                $stripe_customer_id = $customer->id;

            }catch(Exception $e) {
                $api_error = $e->getMessage();
            }
        }else{
            $stripe_customer_id = $UserInfo->stripe_customer_id;
        }



        if(empty($api_error)){
            if(empty($api_error)){
                // Creates a new subscription
                try {
                    $subscription = \Stripe\Subscription::create(array(
                        "customer" => $stripe_customer_id,
                        "trial_end" => strtotime("+" . $SettingsInfo->trial_days . " days"),
                        "items" => array(
                            array(
                                "price" => $PlanInfo->stripe_id,
                            ),
                        ),
                    ));
                }catch(Exception $e) {
                    $api_error = $e->getMessage();
                }

                if(empty($api_error) && $subscription){
                    // Retrieve subscription data
                    $subsData = $subscription->jsonSerialize();

                    // Check whether the subscription activation is successful
                    if($subsData['status'] == 'active' || $subsData['status'] == 'trialing'){
//                        Payments::create([
//                            'user_id' => $current_user_id,
//                            'plan_id' => $PlanInfo->id,
//                            'amount' => $PlanInfo->price,
//                            'type' => 'New',
//                        ]);

                        DB::table('users')->where('id', $current_user_id)
                            ->update([
                                'plan_id' => $PlanInfo->id,
                                'device_id' => substr($UserInfo->email,0, 3) . substr(md5(date("dmyhis") . rand(100,999) . "ECdt-5k!OPC1tv"), 16),
                                'stripe_sub_id' => $subscription->id,
                                'stripe_sub_start' => date("Y-m-d H:i:s", $subsData['current_period_start']),
                                'stripe_trial' => 1,
                                'scrape_limit' => $SettingsInfo->trial_credits
                            ]);

                        $sub_successful = true;
                    }else{
                        //$statusMsg = "Subscription activation failed!";
                    }
                }else{
                    //$statusMsg = "Subscription creation failed!";
                }
            }else{
                //$statusMsg = "Plan creation failed!";
            }
        }else{
            //$statusMsg = "Invalid card details!";
        }

        if($sub_successful == true){
            return redirect("/setup/app");
        }else{
            $SettingsInfo = DB::table("settings")->first();
            $MonthlyPlans = DB::table("plans")->where("frequency", "monthly")->where("status", "<", 2)->get();
            $AnnualPlans = DB::table("plans")->where("frequency", "annually")->where("status", "<", 2)->get();

            return view("setup.index", ["MonthlyPlans" => $MonthlyPlans, "AnnualPlans" => $AnnualPlans, "TrialDays" => $SettingsInfo->trial_days, "Failed" => "Yes"]);
        }

    }




}
