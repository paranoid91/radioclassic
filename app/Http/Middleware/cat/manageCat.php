<?php

namespace App\Http\Middleware\cat;

use Closure;
use App\Cat;

class manageCat
{
    protected $cat;
    public function __construct(Cat $cat){
        $this->cat = $cat;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->user()->hasRole('Super Admin') && $this->cat->findOrFail($request->route()->categories)->parent <= 0){
            if ($request->ajax())
            {
                return response('You don`t have permissions.');
            }else{
                flash()->error('You don`t have permissions.');
                return redirect(action('Admin\CategoriesController@index'));
            }

        }
        return $next($request);
    }
}
