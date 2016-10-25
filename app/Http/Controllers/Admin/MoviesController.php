<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Cat;
use App\Http\Requests\MovieRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MoviesController extends Controller
{
    protected $perms = [], $auth, $post;

    /**
     * @var string
     */
    protected $moduleName= 'movies';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName)]); // add movies permissions
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Cat $cats,Request $request)
    {
        $movies =  (!filter_request($request,'m_filter'))
            ? Article::where('lang',App::getLocale())->orderBy('status','asc')->orderBy('published_at','desc')->ordercat([8])->paginate(get_setting('pagination_num'))
            : Article::where('lang',App::getLocale())->orderBy('status','asc')->orderBy('published_at','desc')->ordercat([8])->filter($request,'m_')->paginate(get_setting('pagination_num'));
        $cats = $cats->select('id','name','parent')->posts(8)->orderBy('name')->get();
        return view('admin.movies.index',compact('movies','cats','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Cat $cats,User $users)
    {
        $users = $users->latest('name')->orderrolein(['Author'])->get();
        $users = array_pluck($users,'name');
        $users = array_name($users);
        $auth = (Auth::user()->hasRole('Author')) ? Auth::user()->name : null;
        $cats = $cats->select('id','name','parent')->posts(8)->orderBy('name')->get();
        return view('admin.movies.create',compact('cats','users','auth'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MovieRequest $request
     * @param Movie $Movie
     * @return Response
     */
    public function store(MovieRequest $request,Article $movie)
    {
        $this->post = $this->auth->articles()->create($request->all());

        $movie->addCat(['cat'=>[$request->input('cat')],'id'=>$this->post->id]);

        flash()->success(trans('movies.added'));

        return redirect(action('Admin\MoviesController@index'));
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
    public function edit($id,Cat $cats,User $users)
    {

        $movie = Article::where('id',$id)->ordercat([8])->get();
        $movie = $movie[0];
        $users = $users->latest('name')->orderrolein(['Author'])->get();
        $users = array_pluck($users,'name');
        $users = array_name($users);
        $auth = (Auth::user()->hasRole('Author')) ? Auth::user()->name : null;
        $cats = $cats->select('id','name','parent')->posts(8)->orderBy('name')->get();
        return view('admin.movies.edit',compact('movie','cats','users','auth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,MovieRequest $request)
    {
        $movie = Article::findOrFail($id);
        $movie->update($request->all());
        $movie->updateCat(['cat'=>[$request->input('cat')],'id'=>$id]);
        flash()->success(trans('movies.updated'));
        return redirect(action('Admin\MoviesController@index'));
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

        return trans(trans('movies.removed'));
    }

    public function filter(Request $request){
        filter_cookies($request,'m_');
        return redirect(action('Admin\MoviesController@index'));
    }

    public function active($id,Article $article){
        Cache::flush();
        $article = $article->findOrFail($id);

        return trans('Movie #'.$id.' is '.$article->articleStatus($article).' now');
    }
}
