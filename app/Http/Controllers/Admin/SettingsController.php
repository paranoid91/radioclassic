<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    protected $perms = [], $auth;

    /**
     * @var string
     */
    protected $moduleName= 'settings';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName)]); // add settings permissions
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::select('name','value')->where('load',3)->where('lang',\App::getLocale())->get();
        return view('admin.settings.index',compact('settings'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $load
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Setting $setting)
    {
        Cache::forget('settings_'.\App::getLocale());
        $setting->updateSettings($request,[
            'site_title',
            'site_tags',
            'site_description',
            'allow_registration',
            'pagination_num',
            'slider_time',
            'banner_time'
        ]);
        flash()->success(trans('all.entry_updated'));
        return redirect(action('Admin\SettingsController@index'));
    }


}
