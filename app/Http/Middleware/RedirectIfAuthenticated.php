<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {            
                switch (Auth::guard($guard)) {
                    case 'customer':
                        return redirect(RouteServiceProvider::DASHBOARD);
                        break;   
                    case 'web':
                        return redirect(RouteServiceProvider::HOME);
                        break;                 
                    default:
                        return redirect(RouteServiceProvider::HOME);
                        break;
                }
            }
        }

        return $next($request);
    }
}
