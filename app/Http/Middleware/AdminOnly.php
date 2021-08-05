<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminOnly
{

    public function handle(Request $request, Closure $next)
    {
        $current_user_id = Auth::id();
        $UserData = User::where('id', $current_user_id)->first();

        if($UserData->access < 2){
            return redirect()->back();
        }else{
            return $next($request);
        }
    }
}
