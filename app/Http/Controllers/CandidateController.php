<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\FormBuilder;
use App\Models\SearchScheduler;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Generate a html form on the page
        $form_content = array(
            // Type, Display Name, DB Name, Placeholder, Value
            array('text_required', "Search Name", "search_name", "", ""),
            array('text_required', "Sales Navigator URL", "search_url", "", ""),
            array('submit', "Search")
        );
        $form_html = FormBuilder::create_form("talent/search", $form_content);

        return view('talent.index', ['form_html' => $form_html]);
    }


    public function search(Request $request)
    {
        $current_user_id = Auth::id();
        $randTrackingID = Auth::id() . ":" . substr(str_shuffle(MD5(date("dhm"))), 0, 10);

        // Validate data, if criteria is not met it fails back to the page advising the user
        $FormData = $request->validate([
            'search_name' => 'required|max:255',
            'search_url' => 'required|max:500'
        ]);

        //User::create($FormData);
        SearchScheduler::create([
            'user_id' => $current_user_id,
            'tracking_id' => $randTrackingID,
            'name' => $request->search_name,
            'url' => $request->search_url,
            'status' => 0,
            'scrape_status' => 0,
            'snov_status' => 0
        ]);

        return redirect(route("talentlist"));
    }

}
