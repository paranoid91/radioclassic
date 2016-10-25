<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Cat;
use App\Http\Requests\BannerRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class BannersController extends Controller
{
    protected $perms = [], $auth, $post, $children = [];
    /**
     * @var string
     */
    protected $moduleName= 'banners';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName)]); // add banners permissions
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $banners = Banner::where('lang',App::getLocale())->latest('published_at')->paginate(get_setting('pagination_num'));

        $banners_new = Banner::orderBy("id", "desc")->get();

        return view('admin.banners.index',compact('banners', "banners_new"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cats = Cat::select('id','name')->posts([26])->get();
        $cats = array_id_name($cats);
        return view('admin.banners.create',compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(BannerRequest $request){
        $banner = Banner::create($request->all());
        $banner->addCat(['cat'=>[$request->input('cat')],'id'=>$banner->id]);
        flash()->success(trans('banners.added'));

        return redirect(action('Admin\BannersController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $cats = Cat::select('id','name')->posts([26])->get();
        $cats = array_id_name($cats);
        $selected = $banner->categories()->select('cat_id')->where('banner_id',$id)->get()[0]->cat_id;
        return view('admin.banners.edit',compact('cats','banner','selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(BannerRequest $request,$id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update($request->all());
        $banner->updateCat(['cat'=>[$request->input('cat')],'id'=>$id]);
        flash()->success(trans('banners.updated'));
        return redirect(action('Admin\BannersController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Banner::findOrFail($id)->delete();
        return trans('banners.removed');
    }
}
