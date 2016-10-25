<?php

namespace App\Http\Middleware;

use Closure;

class RedirectUser
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

        if($request->user()->hasRole('User')){
            return redirect(action('ErrorsController@show',404));
        }
        return $next($request);
    }
}
