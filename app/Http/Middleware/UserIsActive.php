<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsActive
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
        if (Auth::check())
        {
            if (Auth::User()->is_active != '1')
            {
                Auth::logout();
                // return redirect()->route('login')->with('warning', 'Your session has expired because your password is deactivated.');
                return redirect()->route('login')->with('warning', 'Your account has been deactivated. Please contact Administrator.');
            }
        }
        return $next($request);
    }
}
