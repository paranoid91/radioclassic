<?php

namespace App\Http\Middleware;

use Closure;

class RedirectNotLoggedIn
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
        if(! $request->user()){
            return redirect(action('ErrorsController@show',404));
        }
        return $next($request);
    }
}
