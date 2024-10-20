<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CanAccessDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $isAllowedUsers = 1;

        if(Auth::check()  &&  Auth::user()->id == $isAllowedUsers){
            return $next($request);
        }
       
         // If not allowed, redirect to home or another route
         return redirect()->route('home')->with('error', 'You are not authorized to access the dashboard.');
    }
}
