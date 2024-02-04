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
        if(auth()->user()->role == 'HR' || auth()->user()->role == 'ADMIN'){
            return $next($request);
        }
        return redirect()->away('http://127.0.0.1:8000/404');
    }
}
