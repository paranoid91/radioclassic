<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Cache;
class MenuBuilderController extends Controller
{

    /**
     * @var string
     */
    protected $moduleName= 'menu-builder';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName,['custom'])]); // add menu-builder permissions
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Setting::select('name','created_at','id','lang')->where('type','menu')->where('lang',\App::getLocale())->paginate(get_setting('pagination_num'));
    
        return view('admin.menu.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $custom_urls = Setting::select('name','value')->where('type','menu_url')->get();
        return view('admin.menu.create',compact('custom_urls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Setting $setting)
    {
        $setting->create($request->all());
        flash()->success(trans('all.successfully_added'));
        return action('Admin\MenuBuilderController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Setting::findOrFail($id);
        $custom_urls = Setting::select('name','value')->where('type','menu_url')->get();
        return view('admin.menu.edit',compact('item','custom_urls'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request->all());
        Cache::flush();
        flash()->success(trans('all.successfully_updated'));
        return action('Admin\MenuBuilderController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Setting::findOrFail($id)->delete();
        return trans('all.removed');
    }

    /**
     * Adding Custom URL for Menu Builder
     */
    public function custom(SettingRequest $request,$id){
        Setting::create($request->all());
        flash()->success(trans('all.added'));
        return redirect(action('Admin\MenuBuilderController@edit',$id));
    }
}
