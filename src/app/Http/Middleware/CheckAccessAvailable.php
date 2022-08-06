<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Route;

class CheckAccessAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->isUser()){
            return redirect()->route('home');
        }
        // elseif(Auth::user()->isBaned()){
        //     return redirect()->route('home');
        // }
        elseif (!Auth::user()->CheckAccessForUser(Route::currentRouteName())) {
            return redirect()->route('administrator.dashboard');
        }
        return $next($request);
    }
}
