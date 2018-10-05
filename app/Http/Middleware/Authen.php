<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $quard = 'web')
    {
        if(!Auth::guard($quard)->check()){
            return redirect()->route('/');
        }
        return $next($request);
    }
}
