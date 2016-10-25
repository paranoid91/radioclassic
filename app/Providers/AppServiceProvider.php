<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$banners = [];
		$brs = \App\Banner::orderBy("id", "desc")->get();

		foreach($brs as $b)
		{
			if(time() < strtotime($b->finished_at))
			{
				$banners[] = $b;
			}
		}

		$xuina = App\Article::where('lang',App::getLocale())->maincat([1])->where("title", "Kuuluvuus")->get();

		if( !is_null($res = \App\Setting::where("name", "Main Menu")->get()) && !empty($res[0]->value) )
		{
			$menu = json_decode($res[0]->value, true);
			view()->share(["menu" => $menu, "banners" => $banners, "xuina" => $xuina]);
		}


		view()->share(["banners" => $banners, "xuina" => $xuina]);

		/*$banners = \App\Banner::orderBy("id", "desc")->get();

		if( !is_null($res = \App\Setting::where("name", "Main Menu")->get()) && array_key_exists(0, $res) )
		{
			$menu = json_decode($res[0]->value, true);
			view()->share(["menu" => $menu, "banners" => $banners]);
		}

		view()->share("banners", $banners);*/

	}
	

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
