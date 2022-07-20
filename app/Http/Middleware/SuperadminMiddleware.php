<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperadminMiddleware
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
        if(Auth::check()) {
            // if (Auth::user()->operator->ec == 0) {
            //     return redirect('/admin/express-tech/elenco');
            // }
            return $next($request); 
        }else{  
            return redirect('/admin/login');
        }
    }
}
