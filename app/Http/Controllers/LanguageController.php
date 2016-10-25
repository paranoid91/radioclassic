<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\RequestStack;
use Cookie;

class LanguageController extends Controller {

    /**
     *
     * Language chose result
     * @param Requests $request
     * @return mixed
     */
    public function choser(Request $request){


        \Session::put('locale',$request->get('locale'));

        return redirect()->back();
    }

    /**
     *
     * Language chose result as cookie
     * @param Requests $request Cookie
     * @return mixed
     */
    public function cookie(Request $request){
        Cookie::queue('locale',$request->get('locale'));
        return redirect()->back();
    }

}
