<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\FormBuilder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        // Get all from User table
        $TableArray = User::where('access', 1)
            ->orderBy('client_id', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();

        return view('users.index', ['TableArray' => $TableArray]);
    }

}
