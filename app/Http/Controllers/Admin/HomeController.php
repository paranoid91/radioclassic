<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Article;
use App\Cat;
use Illuminate\Support\Facades\App;


class HomeController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('language');
	}

	public function index(User $users, Cat $cats,Request $request)
	{
		$record_items = $cats->select('id')->post(2)->get();
		$users = $users = $users->getUsers(['Author','DJs']);

		$cats = $cats->select('id','name','parent')->posts(array_pluck($record_items,'id'))->orderBy('name')->get();
		foreach($cats as $c){
			$this->children[] = $c['id'];
		}
		$articles =
			(!filter_request($request,'a_filter'))
				? Article::orderBy('status','asc')->orderBy('published_at','desc')->where('lang',App::getLocale())->latest('status')->orderall($this->children)->paginate(get_setting('pagination_num'))
				: Article::orderBy('status','asc')->orderBy('published_at','desc')->where('lang',App::getLocale())->orderall($this->children)->filter($request,'a_')->paginate(get_setting('pagination_num'));
		return view('admin.articles.index',compact('articles','request','query','cats', "users"));
	}

	//page preview

	public function previewPage(Request $request)
	{
		return view("theme.pages.preview", compact("request"));
	}

	public function storeSess(Request $request)
	{
		if( !empty($request->all()) )
		{
			$request->session()->put("title", $request->title);
			$request->session()->put("body", $request->body);
			$request->session()->put("img", $request->img);
			return http_response_code(400);
		}
	}

}
