<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventMultipleLogins
{
   public function handle(Request $request, Closure $next)
{
    if (Auth::check() && ($request->is('login') || $request->is('register'))) {
        // Instead of staying on page, redirect them to homepage
        return redirect('/homepage')->with('message', 'You are already logged in.');
    }

    return $next($request);
}


}




