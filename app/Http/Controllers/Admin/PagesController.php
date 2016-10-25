<?php

namespace App\Http\Controllers\Admin;


use App\Article;
use App\Field;
use App\Http\Requests\PageRequest;



use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Html;
use Illuminate\Support\Facades\Cache;


class PagesController extends Controller
{

    protected $perms = [], $auth, $post;

    /**
     * @var string
     */
    protected $moduleName= 'pages';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName)]); // add pages permissions
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages =  Article::where('lang',App::getLocale())->latest()->maincat([1])->paginate(get_setting('pagination_num'));

        return view('admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.pages.create',compact('fields'));
    }


    public function store(PageRequest $request,Article $page)
    {
        $this->post = Auth::user()->articles()->create($request->all());
        $page->addCat(['cat'=>[1,$request->input('cat')],'id'=>$this->post->id]);
        //Cache::flush();
        flash()->success(trans('pages.added'));

        return redirect(action('Admin\PagesController@index'));
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
        $page = Article::findOrFail($id);
        return view('admin.pages.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,PageRequest $request)
    {
        $page = Article::findOrFail($id);
        $page->update($request->all());
        $page->updateCat(['cat'=>[1,$request->input('cat')],'id'=>$id]);
        //Cache::flush();
        flash()->success(trans('pages.updated'));
        return redirect(action('Admin\PagesController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();

        return trans('pages.removed');
    }
}
