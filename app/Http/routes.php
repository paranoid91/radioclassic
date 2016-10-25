<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/test',function(){
    return App\Dev\Facades\Foo::bar();
});
Route::get('is-admin/auth',['middleware'=>['ManagerLoggedIn','language'],'uses'=>'Auth\AuthController@newLogin']);
Route::post('user/login','Auth\AuthController@postLogin');
Route::get('user/logout','Auth\AuthController@getLogout');
Route::get('user/logout','Auth\AuthController@newLogout');
Route::post('user/check','Auth\AuthController@checkLogin');

Route::group(['middleware'=>['language','RedirectUser','auth']],function(){
    /*
 * Admin Home
 */
    Route::post('user/registration','Auth\AuthController@registration');
    Route::get('is-admin/home', ['middleware'=>'RedirectUser','uses'=>'Admin\HomeController@index']);

    Route::post("is-admin/preview-page/{params}", "Admin\HomeController@storeSess");
    Route::get("is-admin/preview-page/{params}", "Admin\HomeController@previewPage");

    /*
     * Settings
     */
    Route::get('is-admin/settings','Admin\SettingsController@index');
    Route::patch('is-admin/settings/update','Admin\SettingsController@update');
    /*
     * Modules
     */
    Route::resource('is-admin/modules','Admin\ModulesController');
    Route::put('is-admin/modules/active/{id}','Admin\ModulesController@active');
    Route::put('is-admin/modules/sort/{id}','Admin\ModulesController@sort');
    /*
     * Fields
     */
    Route::get('is-admin/fields/{id}','Admin\FieldsController@show');
    Route::put('is-admin/fields/store/{id}','Admin\FieldsController@store');
    Route::put('is-admin/fields/update/{id}','Admin\FieldsController@update');
    Route::put('is-admin/fields/drop/{id}','Admin\FieldsController@drop');
    /*
     * Billing
     */
    Route::resource('is-admin/billings','Admin\BillingsController');
    Route::put('is-admin/billings/active/{id}','Admin\BillingsController@active');


    Route::get('payment/check/{bank_id?}',['middleware'=>'BankAuth','uses'=>'Admin\BillingsController@check']);
    Route::get('payment/register/{bank_id?}',['middleware'=>'BankAuth','uses'=>'Admin\BillingsController@pay']);
    /*
     * Roles
     */


    Route::resource('is-admin/roles','Admin\RolesController');



    /*
     * Pages
     */
    Route::resource('is-admin/pages','Admin\PagesController');
    Route::post('/is-admin/pages/create','Admin\PagesController@create');
    /*
     * Movies
     */
    Route::resource('is-admin/movies','Admin\MoviesController');
    Route::post('is-admin/movies/filter','Admin\MoviesController@filter');
    Route::put('is-admin/movies/active/{id}','Admin\MoviesController@active');
    /*
     * Poll
     */
    Route::resource('is-admin/polls','Admin\PollsController');
    Route::put('is-admin/categories/active/{id}','Admin\PollsController@active');
    Route::put('vote','Admin\PollsController@vote');

    /*
     * Categories
     */

    Route::resource('is-admin/categories','Admin\CategoriesController');
    Route::put('is-admin/categories/sort/{id}','Admin\CategoriesController@sort');

    /*
     * Authorisation
     */
    /*
    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);*/


    /*
     * Admin Slider
     */

    Route::get('is-admin/slider','Admin\SliderController@index');

    Route::get('is-admin/slider/{slider}/edit','Admin\SliderController@edit');
    Route::patch('is-admin/slider/{slider}','Admin\SliderController@update');

    Route::get('is-admin/slider/create','Admin\SliderController@create');
    Route::post('is-admin/slider','Admin\SliderController@store');

    Route::delete('is-admin/slider/{slider}','Admin\SliderController@destroy');

    /*
     * Users
     */

    Route::resource('is-admin/users','Admin\UsersController');
    Route::get('user/{id}','Admin\UsersController@frontEdit');
    Route::post('ajax/user','Admin\UsersController@getAjaxUserName');

    /*
     * Banners
     */
    Route::resource('is-admin/banners','Admin\BannersController');
    /*
     * Menu
     */
    Route::resource('is-admin/menu','Admin\MenuBuilderController');
    Route::post('is-admin/menu/{id}/edit','Admin\MenuBuilderController@custom');
    /*
     * Language
     */
    Route::post('/language',['before'=>'csrf','as'=>'language-choser','uses'=>'LanguageController@choser']);
    Route::post('/language_cookie',['before'=>'csrf','as'=>'language-cookie','uses'=>'LanguageController@cookie']);
    /*
     * Images Gallery
     */
    Route::resource('is-admin/gallery','Admin\ImagesController');
    Route::post('is-admin/gallery/filter','Admin\ImagesController@filter');
    Route::put('is-admin/gallery/active/{id}','Admin\ImagesController@active');
    Route::post('field/get','Admin\ImagesController@imgField');
});

/*
 * Errors
 */

Route::get('/error/{id}','ErrorsController@show');

/*
 * PlaylistXML
 */

//Route::get('cron/playlist/xml','WelcomeController@getPlaylistXml');
Route::get('/get/xml/playlist',function(){
    $xmlPlaylist = Cache::get('currentPlaylist');
    return $xmlPlaylist;
});
/**
 * AJAX
 */
Route::get('ajax/index','WelcomeController@ajaxIndex');
Route::get('ajax/show/{cat}/{id}','WelcomeController@ajaxShow');
Route::get('ajax/¡/{cat}','WelcomeController@ajaxCat');
Route::get('ajax/search/{text}','WelcomeController@ajaxSearch');
/*
 * FRONT INDEX
 */

Route::post('/soitetut','WelcomeController@searchPlaylist');
Route::get('/','WelcomeController@index');
Route::post('/','WelcomeController@index');
Route::get('poll/{id}','WelcomeController@poll');
Route::get('language/get','WelcomeController@language');
Route::get('{cat}','WelcomeController@showCat');
Route::post('records/load','WelcomeController@loadRecords');
Route::get('search/{text}','WelcomeController@showSearch');
Route::post('search/load','WelcomeController@loadSearch');
//Route::get('cat/{slug}','WelcomeController@articleList');
//Route::get('gallery/{id}','WelcomeController@imageShow');
//Route::get('image/gallery','WelcomeController@images');
//Route::get('rss/feed','WelcomeController@rss');
//Route::get('currency/generator','WelcomeController@currency');

//Route::get('search/news','WelcomeController@search');

/*
 * webform
 */
Route::post('email/send/competition','WelcomeController@sendComp');
Route::get('email/send/competition','WelcomeController@sendComp');
/*
 * Articles
 */

//sort news
Route::get("is-admin/articles/sort-news", "Admin\ArticlesController@sortNews");
Route::post("is-admin/articles/sort-news", "Admin\ArticlesController@saveOrder");

Route::get('brightcove/videos','Admin\ArticlesController@brightCove');
Route::post('brightcove/videos','Admin\ArticlesController@brightCove');
Route::resource('is-admin/articles','Admin\ArticlesController');
Route::post('is-admin/articles/filter','Admin\ArticlesController@filter');
Route::get('{cat}/{id}','WelcomeController@show');
Route::put('is-admin/articles/active/{id}','Admin\ArticlesController@active');
Route::post('is-admin/articles/event','Admin\ArticlesController@event');
Route::post('is-admin/articles/getEvents','Admin\ArticlesController@getEvents');
Route::post('is-admin/articles/getCats','Admin\ArticlesController@getCats');
Route::post('is-admin/articles/getFields','Admin\ArticlesController@getFields');

Route::post('ajax/tags','Admin\ArticlesController@getAjaxTags');

Route::get('/cron/playlist/images','CronController@playlistImages');
Route::get('/cron/playlist/xml/wau8u3218d1j213','CronController@getPlaylistXml');



/*
 * TESTs
 */
