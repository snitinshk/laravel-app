<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\FormBuilder;
use App\Models\Clients;

class ClientsController extends Controller
{

    public function index()
    {
        // State what actions you want in the Table Action Bar
        $TableActionBar = array(
            // Display Name, Icon Name, Slug
            array("Add Client", "plus", "clients/add"),
        );

        // Get all from User table
        $TableArray = Clients::all();

        // State column names you want to display from the table
        $TableColumns = array('Name', 'Contact Name', 'Email Address', 'Date Created', 'Status');

        // State what actions you want in the row
        $RowOptions = array(
            // Display Name, Icon Name, Slug
            array("Edit", "pencil", "edit"),
            array("Enable", "checkmark", "enable"),
            array("Disable", "ban", "disable")
        );

        return view('clients.index', ['TableActionBar' => $TableActionBar, 'TableColumns' => $TableColumns, 'TableArray' => $TableArray, 'RowOptions' => $RowOptions]);
    }


    public function create()
    {
        // Generate a html form on the page
        $form_content = array(
            // Type, Display Name, DB Name, Placeholder, Value
            array('text', "Name", "name", "", ""),
            array('text', "Contact Name", "contact_name", "", ""),
            array('text', "Email Address", "email_address", "", ""),
            array('text', "Phone Number", "phone_number", "", ""),
            array('submit', "Save")
        );
        $form_html = FormBuilder::create_form("clients/add", $form_content);

        return view('clients.create', ['form_html' => $form_html]);
    }


    public function store(Request $request)
    {
        // Validate data, if criteria is not met it fails back to the page advising the user
        $FormData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:clients',
            'phone_number' => 'required|string|min:8',
        ]);

        //User::create($FormData);
        Clients::create([
            'name' => $request->name,
            'contact_name' => $request->contact_name,
            'email_address' => $request->email_address,
            'phone_number' => $request->phone_number,
            'status' => 2,
        ]);

        return redirect(route("clients"));
    }


    public function edit($id)
    {
        // Get all from User table where id = $id
        $ClientData = Clients::findOrFail($id);

        // Generate a html form on the page
        $form_content = array(
            // Type, Display Name, DB Name, Placeholder, Value
            array('text', "Name","name","",$ClientData->name),
            array('text', "Contact Name","contact_name","",$ClientData->contact_name),
            array('text', "Email Address","email_address","",$ClientData->email_address),
            array('text', "Phone Number","phone_number","",$ClientData->phone_number),
            array('submit', "Save")
        );
        $form_html = FormBuilder::create_form("clients/edit/{$id}", $form_content);

        return view('clients.edit', ['form_html' => $form_html]);
    }


    public function update(Request $request, $id)
    {
        // Validate data, if criteria is not met it fails back to the page advising the user
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email_address' => 'required|string|email|max:255',
            'phone_number' => 'required|string|min:8',
        ]);

        //Finds record using model, updates fields from Edit and saves
        $ClientData = Clients::findOrFail($id);
        $ClientData->name = $request->name;
        $ClientData->contact_name = $request->contact_name;
        $ClientData->email_address = $request->email_address;
        $ClientData->phone_number = $request->phone_number;
        $ClientData->save();

        return redirect(route("clients"));
    }


    public function enable(Request $request, $id)
    {
        //Finds record using model, updates fields from Edit and saves
        $ClientData = Clients::findOrFail($id);
        $ClientData->status = 2;
        $ClientData->save();

        return redirect(route("clients"));
    }


    public function disable(Request $request, $id)
    {
        //Finds record using model, updates fields from Edit and saves
        $ClientData = Clients::findOrFail($id);
        $ClientData->status = 1;
        $ClientData->save();

        return redirect(route("clients"));
    }

}
