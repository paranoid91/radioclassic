<?php namespace App\Http\Middleware;

use Closure;
use Torann\GeoIP\GeoIP;

class Language {
    /*
    public $language;
    public function __construct(GeoIP $geoip){
       $this->langauge = $geoip->getLocation()['isoCode'];
    }
    */
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        /*
        if(\Session::get('locale') == "") {
            switch(strtolower($this->langauge)){
                case 'ge' :
                    \Session::put('locale','ge');
                    break;
                case 'ru' :
                    \Session::put('locale','ru');
                    break;
                case 'ua' :
                    \Session::put('locale','ru');
                    break;
                default:
                    \Session::put('locale','en');
                    break;
            }
        }*/
        $locale = (!empty($request->cookie('locale'))) ? $request->cookie('locale') : \App::getLocale();
        \App::setLocale($locale);
		return $next($request);
	}


}
