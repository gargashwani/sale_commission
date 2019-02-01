<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->user_role == 'manager')
        {   // redirect with flash session message
            dd(Auth::user());
            // return redirect('/home')->with('message','You are Not Allowed To Access!');
        }
        return $next($request);
    }
}
