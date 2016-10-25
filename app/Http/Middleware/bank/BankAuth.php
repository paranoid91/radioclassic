<?php

namespace App\Http\Middleware\bank;

use Closure;
use Illuminate\Support\Facades\Auth;

class BankAuth
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
        if(!$this->validateUser($request)){
            return  $this->getHttpAuth();
        }
            return $next($request);
    }

    private function getHttpAuth()
    {
        $headers = ['WWW-Authenticate' => 'Basic'];
        return Response('Invalid credentials.', 401, $headers);
    }

    private function validateUser($request){
        if($request->getUser() == 'test' && $request->getPassword() == '12345')
            return true;
        else
            return false;
    }
}
