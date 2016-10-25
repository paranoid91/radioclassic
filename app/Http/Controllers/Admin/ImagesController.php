<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageRequest;
use App\Image;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ImagesController extends Controller
{

    protected $perms = [], $auth, $post;
    /**
     * @var string
     */
    protected $moduleName= 'gallery';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName,['imgField'])]); // add articles permissions
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $gallery =  (!filter_request($request,'g_filter'))
            ? Image::where('lang',App::getLocale())->orderBy('status','asc')->orderBy('published_at','desc')->paginate(get_setting('pagination_num'))
            : Image::where('lang',App::getLocale())->orderBy('status','asc')->orderBy('published_at','desc')->filter($request,'g_')->paginate(get_setting('pagination_num'));
        return view('admin.gallery.index',compact('gallery','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(User $users)
    {
        $users = $users->latest('name')->orderrolein(['Author'])->get();
        $users = array_pluck($users,'name');
        $users = array_name($users);
        $auth = (Auth::user()->hasRole('Author')) ? Auth::user()->name : null;
        return view('admin.gallery.create',compact('users','auth'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ImageRequest $request)
    {
        Image::create($request->all());
        flash()->success(trans('images.added'));
        return redirect(action('Admin\ImagesController@index'));
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
    public function edit($id,User $users)
    {
        $gallery = Image::findOrFail($id);
        $images = unserialize($gallery->images);
        $img_title = unserialize($gallery->img_title);
        $users = $users->latest('name')->orderrolein(['Author'])->get();
        $users = array_pluck($users,'name');
        $users = array_name($users);
        $auth = (Auth::user()->hasRole('Author')) ? Auth::user()->name : null;
        return view('admin.gallery.edit',compact('gallery','images','img_title','users','auth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,ImageRequest $request)
    {
        $image = Image::findOrFail($id);
        $image->update($request->all());
        flash()->success(trans('images.updated'));
        return redirect(action('Admin\ImagesController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Image::findOrFail($id)->delete();

        return trans('images.removed');
    }

    public function filter(Request $request){
        filter_cookies($request,'g_');
        return redirect(action('Admin\ImagesController@index'));
    }

    public function active($id,Image $image){
        Cache::flush();
        $image = $image->findOrFail($id);
        return trans('Gallery #'.$id.' is '.$image->imageStatus($image).' now');
    }

    public function imgField(Request $request){
        $image_gallery = false;
        $num = $request->input('image_id');
        $image_id = $request->input('image_id');
        $content = view('admin.fields.image',compact('num','image_id'));
        $image = view('admin.modals.image',compact('modal_id','num','image_gallery'));
        $output = array('content'=>htmlspecialchars($content, ENT_QUOTES, 'UTF-8'),'image'=>htmlspecialchars($image, ENT_QUOTES, 'UTF-8'));
        return json_encode($output);
    }
}
