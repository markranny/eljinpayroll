<?php

namespace App\Http\Middleware;

use Closure;

class IsHR
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
        /* if(auth()->user()->role == 'HR' || auth()->user()->role == 'ADMIN'){
            return $next($request);
        }
        else{
            return view('auth.login');
        } */

        if (auth()->check()) {
            if (auth()->user()->role == 'HR' || auth()->user()->role == 'ADMIN') {
                return $next($request);
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect('/login');
        }
    }
}
