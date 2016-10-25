<?php namespace App\Http\Controllers;

use App\Article;
use App\Cat;
use App\Image;

use Illuminate\Support\Facades\Session;
use Mail;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Cache;

use Illuminate\Support\Facades\DB;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Reader;

use Response;



class WelcomeController extends Controller {

    protected $articles,$registry;
	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Article $articles)
	{
        $this->articles = $articles;
        $this->middleware('language');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$xmlPlaylist = Cache::get('currentPlaylist');
		//getting news list on front page
		$news = Cache::remember('news_'.App::getLocale(),5,function(){
			return Article::select('id','title','frontpage_title','head','body','slug','extra_fields','published_at','img', 'pos')->lang(App::getLocale())->orderBy('published_at','desc')->published()->bycatslug('news')->take(10)->get();
		});

		$news = sortByPos($news);
		
		//getting events list on front page
		//$events = Article::select('id','title','frontpage_title','slug','extra_fields','published_at','img')->lang(App::getLocale())->orderBy('published_at','desc')->published()->bycatslugs(['free-event','premium-event'])->take(6)->get();
		//getting videos list on front page
		//$videos = Article::select('id','title','frontpage_title','slug','extra_fields','published_at','img')->lang(App::getLocale())->latest()->published()->getone(77)->take(2)->get();
        set_globals(['title'=>get_setting('site_title')]);
		return view('pages.front.index',compact('xmlPlaylist','news','events'));
	}


	/**
	 * @param Request $request
	 * @return bool|string
     */
	public function language(Request $request){
        if($request->input('trans'))
            return trans($request->input('trans'));
        else
            return false;
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showCat($cat)
	{
		$xmlPlaylist = Cache::get('currentPlaylist');
		$new_cat = ($cat == 'events') ? ['free-event','premium-event'] : [$cat];
		$items = Article::select('id','title','frontpage_title','head','body','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->orderBy('published_at','desc')->published()->bycatslugs($new_cat)->take(10)->get();
		if(count($items) > 0){
			return view('theme.pages.records.showCat',compact('items','xmlPlaylist'));
		}else{
			$item = Article::select('id','title','frontpage_title','head','body','extra_fields','published_at','img')->where('slug',$cat)->published()->first();
			set_globals([
				'title'=>$item->title,
				'social_title'=>check_value($item->social_media_title,$item->title),
				'description'=>trim(str_limit(preg_replace('/(<.*?>)|(&.*?;)/', '', strip_tags($item->body)), $limit = 200, $end = '...' )),
				'author'=>$item->author,
				'keyword'=>check_value(get_setting('site_tags'),$item->meta_key),
				'pubdate'=>date('Y-m-d H:i:s',strtotime($item->published_at)),
				'lastmod'=>date('Y-m-d H:i:s',strtotime($item->updated_at)),
				'type'=>'section',
				'section'=>$cat,
				'url'=>url($cat),
				'image'=>(!empty($item->img)) ? $item->img :
						(preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i',$item->body,$image) == true) ? asset($image['src']) : ''
			]);
			$images = [];
			$items = [];
			set_globals(['title'=>$item->title]);
			return view('theme.pages.views',compact('item','xmlPlaylist','images','items'));
		}

	}


	/**
	 * @param Request $request
	 * @return int
     */
	public function loadRecords(Request $request){
		$new_cat = ($request->input('slug') == 'events') ? ['free-event','premium-event'] : [$request->input('slug')];
		$items = Article::select('id','frontpage_title','title','slug','head','extra_fields','published_at','img','body')->lang(App::getLocale())->orderBy('published_at','desc')->published()->bycatslugs($new_cat)->take($request->input('num'))->skip($request->input('records'))->get();
		$youtube_video = false;

		if($request->input('slug') == "youtube"){
			$youtube_video = true;
		}

		if(count($items) > 0){
			return view('theme.pages.ajax.records',compact('items', "youtube_video"));
		}else{
			return 0;
		}
	}


	/**
	 * @param $text
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function showSearch($text)
	{
		$xmlPlaylist = Cache::get('currentPlaylist');
		$items = Article::select('id','title','head','body','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->orderBy('published_at','desc')->published()->search($text)->take(10)->get();
		return view('theme.pages.records.showSearch',compact('text','xmlPlaylist','images','items'));
	}

	/**
	 * @param $text
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function ajaxSearch($text)
	{
		$xmlPlaylist = Cache::get('currentPlaylist');
		$items = Article::select('id','title','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->orderBy('published_at','desc')->published()->search($text)->take(9)->get();
		return view('theme.pages.iframe.showSearch',compact('text','xmlPlaylist','images','items'));
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|int
     */
	public function loadSearch(Request $request){
		$text = $request->input('slug');
		$items = Article::select('id','title','slug','extra_fields','published_at','img')->lang(App::getLocale())->orderBy('published_at','desc')->published()->search($text)->take($request->input('num'))->skip($request->input('records'))->get();
		if(count($items) > 0){
			return view('theme.pages.ajax.records',compact('items'));
		}else{
			return 0;
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($cat,$sid)
	{
		$xmlPlaylist = Cache::get('currentPlaylist');
		$item = Article::select('id','title','frontpage_title','social_media_title','head','body','author','extra_fields','published_at','updated_at')->where('id',$sid)->orWhere('slug',$cat.'/'.$sid)->orWhere('slug',$sid)->getarticlecat()->first();

		$images = $item->images()->get();
		set_globals([
			'title'=>$item->title,
			'social_title'=>check_value($item->social_media_title,$item->title),
			'image'=>(count($images) > 0) ? get_img_url($images[0]->img) : '',
			'description'=>check_value($item->head,str_limit(preg_replace('/(<.*?>)|(&.*?;)/', '', strip_tags($item->body)), $limit = 200, $end = '...' )),
			'author'=>$item->author,
			'pubdate'=>date('Y-m-d H:i:s',strtotime($item->published_at)),
			'lastmod'=>date('Y-m-d H:i:s',strtotime($item->updated_at)),
			'type'=>'article',
			'section'=>$cat,
			'url'=>url($cat.'/'.$sid),
			'keyword'=>check_value(get_setting('site_tags'),$item->meta_key),
		]);
		$new_cat = ($cat == 'events') ? ['free-event','premium-event'] : [$cat];
		if($cat <> 'competition'):
		    $items = Article::select('id','title','frontpage_title','head','body','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->where('id','<>',$item->id)->orderBy('published_at','desc')->published()->bycatslug($new_cat)->take(3)->get();		//DB::table('articles')->where('id',$sid)->orWhere('slug',$sid)->increment('view',1);
			return view('theme.pages.views',compact('item','images','xmlPlaylist','items'));
		else:
			return view('theme.pages.viewCompetition',compact('item','images','xmlPlaylist'));
		endif;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function sendComp(Request $request){
		$content = [];
        $comp = Article::findOrFail($request->input('item'));
		if(!empty($comp->extra_fields)){
			$fields = unserialize($comp->extra_fields);
			foreach($fields['competition']['question'] as $k=>$q){
				if($q['true_answer'] == $request->input('question'.$k)){$answer = 'success';}else{$answer='failed';}
				$content['question'][$k] = $k.'. '.$q['title'].' - '.$answer.'';
			}
			//dump($fields['competition']['question']);
		}
		$content = $content + $request->all();
		Mail::send('theme.pages.emails.competition',['content'=>$content], function($message) use ($request)
		{
			$message->from('radioclassic@radioclassic.fi', 'RadioClassic');
			$message->to('kilpailut@radioclassic.fi')->replyTo($request->input('email'))->subject('Competition - '.$request->input('first_name').' '.$request->input('last_name'));
		});
		flash()->success(trans('front.kilpailut_sent'));
		return redirect($request->input('redirect_url'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function searchPlaylist(Request $request){
		if($request->input('date') <> ""){
			$date = "%".date('Y-m-d',strtotime(Carbon::createFromFormat('d-m-Y',$request->input('date'))))."%";
		}else{
			$date = "%".date('Y-m-d')."%";
		}

		$playlist = Cache::remember('pl_'.$date,2,function() use ($date){
			return DB::table('radio_playlist')->select('tid','img','timestamp','data','download')->orderBy('timestamp','desc')->where('timestamp','LIKE',$date)->get();
		});
		return view('theme.pages.ajax.outgoing',compact('playlist'));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function ajaxIndex(){
		$xmlPlaylist = Cache::get('currentPlaylist');
		//getting news list on front page
		$news = Article::select('id','title','slug','extra_fields','published_at','img')->lang(App::getLocale())->orderBy('published_at','desc')->published()->bycatslug('news')->take(6)->get();
		//getting events list on front page
		$events = Article::select('id','title','slug','extra_fields','published_at','img')->lang(App::getLocale())->orderBy('published_at','desc')->published()->bycatslugs(['free-event','premium-event'])->take(6)->get();
		//getting videos list on front page
		$videos = Article::select('id','title','slug','extra_fields','published_at','img')->lang(App::getLocale())->latest()->published()->getone(77)->take(3)->get();

		return view('theme.pages.iframe.index',compact('xmlPlaylist','news','events','videos'));
	}

	/**
	 * @param $cat
	 * @param $sid
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function ajaxShow($cat,$sid){
		$xmlPlaylist = Cache::get('currentPlaylist');
		$item = Article::select('id','title','body','extra_fields')->where('id',$sid)->orWhere('slug',$cat.'/'.$sid)->orWhere('slug',$sid)->getarticlecat()->first();
		$images = $item->images()->get();
		$new_cat = ($cat == 'events') ? ['free-event','premium-event'] : [$cat];
		if($cat <> 'competition'):
			$items = Article::select('id','title','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->where('id','<>',$item->id)->orderBy('published_at','desc')->published()->bycatslug($new_cat)->take(4)->get();		//DB::table('articles')->where('id',$sid)->orWhere('slug',$sid)->increment('view',1);
			return view('theme.pages.iframe.views',compact('item','images','xmlPlaylist','items'));
		else:
			return view('theme.pages.iframe.viewCompetition',compact('item','images','xmlPlaylist'));
		endif;
	}

	/**
	 * @param $cat
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function ajaxCat($cat)
	{
		$xmlPlaylist = Cache::get('currentPlaylist');
		$new_cat = ($cat == 'events') ? ['free-event','premium-event'] : [$cat];
		$items = Article::select('id','title','frontpage_title','body','head','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->orderBy('published_at','desc')->published()->bycatslugs($new_cat)->take(9)->get();
		if(count($items) > 0){
			return view('theme.pages.iframe.showCat',compact('items','xmlPlaylist'));
		}else{
			$item = Article::select('id','title','frontpage_title','body','extra_fields','published_at','head','updated_at','meta_key','meta_desc','img')->where('slug',$cat)->published()->first();
			set_globals([
				'title'=>$item->title,
				'social_title'=>check_value($item->social_media_title,$item->title),
				'description'=>str_limit(preg_replace('/(<.*?>)|(&.*?;)/', '', strip_tags($item->body)), $limit = 200, $end = '...' ),
				'author'=>$item->author,
				'keyword'=>check_value(get_setting('site_tags'),$item->meta_key),
				'pubdate'=>date('Y-m-d H:i:s',strtotime($item->published_at)),
				'lastmod'=>date('Y-m-d H:i:s',strtotime($item->updated_at)),
				'type'=>'section',
				'section'=>$cat,
				'url'=>url($cat),
				'image'=>(!empty($item->img)) ? $item->img :
					(preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i',$item->body,$image) == true) ? asset($image['src']) : ''
			]);
			$images = [];
			$items = [];
			return view('theme.pages.iframe.views',compact('item','xmlPlaylist','images','items'));
		}
	}



}