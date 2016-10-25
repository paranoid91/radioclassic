<?php namespace App\Http\Middleware;

use Closure;



class RoleManager {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */



    public function handle($request, Closure $next)
    {
        if($request->user()){
            if($request->user()->hasRole(array_pluck($request->user()->roles,'name'))){
                if ($request->ajax())
                {
                    return response('You don`t have permissions.');
                }else{
                    flash()->error('You don`t have permissions.');
                    return redirect()->back();
                }
            }
        }else{
            return redirect(action('ErrorsController@show',404));
        }


        return $next($request);

    }

}
