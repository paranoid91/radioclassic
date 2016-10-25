<?php namespace App\Http\Controllers\Admin;
use App\Article;
use App\Cat;
use App\Image;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ArticlesController extends Controller {

    protected $perms = [], $auth, $post, $children = [];

    /**
     * @var string
     */
    protected $moduleName= 'articles';


    /**
     * CastsController constructor.
     */
    public function __construct(){

        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName,['getCats','getFields','event','getEvents','brightCove','getAjaxTags','sortNews', 'saveOrder'])]); // add articles permissions
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Cat $cats,Request $request)
    {
        $record_items = $cats->select('id')->post(2)->get();
        //dump(array_pluck($record_items,'id'));
        $cats = $cats->select('id','name','parent')->posts(array_pluck($record_items,'id'))->orderBy('name')->get();//get_cat_by_parents([55,56]);
        foreach($cats as $c){
           $this->children[] = $c['id'];
        }
        $articles =
            (!filter_request($request,'a_filter'))
                ? Article::orderBy('status','asc')->orderBy('published_at','desc')->where('lang',App::getLocale())->latest('status')->orderall($this->children)->paginate(get_setting('pagination_num'))
                : Article::orderBy('status','asc')->orderBy('published_at','desc')->where('lang',App::getLocale())->orderall($this->children)->filter($request,'a_')->paginate(get_setting('pagination_num'));
        return view('admin.articles.index',compact('articles','request','query','cats'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(User $user,Request $request)
	{

        $users = $user->getUsers(['Author','3rd party content provider'],'name|asc');

        //$ids = array_pluck($users,'id');
        //$users = $user->orderBy('name','ASC')->userdetails($ids)->get();
        $user_names = array();
        $i=0;foreach($users as $user){
            foreach($user->details as $u){
                $user_names[$user->name] = $u->full_name;
            }
        $i++;
        }


        //$detail = array_get($users->toArray(),'details.full_name');

        //$user_names = array_pluck($user_names,'full_name');

        $users = array_name($user_names);
        $auth = (Auth::user()->hasRole('Author')) ? Auth::user()->name : null;

        $image_gallery = [['img'=>null,'title'=>null,'alt'=>null,'source'=>null,'author'=>null,'meta_desc'=>null,'meta_key'=>null]];
        if(count(Session::get('_old_input')['image']) > 0){
            $image_gallery = '';
            $image_gallery = add_image_array(Session::get('_old_input')['image']);
        }
        $checked_cats = '';
        $catid = '';
        $json_extra = '';
        if(count(Session::get('_old_input')['cat']) > 0) {
            $checked_cats = join(',',Session::get('_old_input')['cat']);
            $catid = Session::get('_old_input')['cat'][0];
        }
        $extra_fields = '';
        if(count(Session::get('_old_input')['extra_fields']) > 0){
            $extra_fields = Session::get('_old_input')['extra_fields'];
            $json_extra = json_encode($extra_fields);
        }



        $fields = hasFields([2],['select'=>['col-sm'=>5],'input'=>['col-sm'=>5],'textarea'=>['col-sm'=>9]],$extra_fields);

		return view('admin.articles.create',compact('users','auth','fields','image_gallery','checked_cats','catid','json_extra','extra_fields'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ArticleRequest $request,Article $article)
	{
        $input = $request->all();
        $input['img'] = (!empty($request->input('image')[0]['img'])) ? $request->input('image')[0]['img'] : '';
        $request->replace($input);
        $this->post = Auth::user()->articles()->create($request->all());
        $article->addCat(['cat'=>$request->input('cat'),'id'=>$this->post->id]);
        foreach($request->input('image') as $img){
            $this->post->images()->create(array_add($img,'article_id',$this->post->id));
        }
        flash()->success(trans('articles.article_added'));

        return redirect(action('Admin\ArticlesController@index'));
	}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id,User $users)
    {
        $item = Article::findOrFail($id);

        $users = $users->getUsers(['Author','3rd party content provider'],'name|asc');
        //$users = array_pluck($users,'id');
        $user_names = array();
        $i=0;
        foreach($users as $user){
            foreach($user->details as $u){
                $user_names[$user->name] = $u->full_name;
            }
            $i++;
        }
        $users = array_name($user_names);
        $child = $item->categories()->select('cat_id')->first();
        $images = $item->images()->get();
        $image_gallery = [['img'=>null,'title'=>null,'alt'=>null,'source'=>null,'author'=>null,'meta_desc'=>null,'meta_key'=>null]];
        if(count($images) > 0){
            $image_gallery = add_image_array($images);
        }
        if(count(Session::get('_old_input')['image']) > 0){
            $image_gallery = add_image_array(Session::get('_old_input')['image']);
        }
        $checked_cats = '';
        $catid = '';
        if(count(Session::get('_old_input')['cat']) > 0){
            $checked_cats = join(',',Session::get('_old_input')['cat']);
            $catid = Session::get('_old_input')['cat'][0];
        }

        $parent= Cat::select('parent')->where('id',$child->cat_id)->first()->parent;
        //$cats = $cats->select('id','name')->latest()->postextra(['parent'=>2,'id'=>[5,6,7]])->get();
        $catid = $child->cat_id;

        $extra_fields = unserialize($item->extra_fields);
        $json_extra = '';
        if(count($extra_fields) > 0 && !empty($extra_fields)){
            $json_extra = json_encode($extra_fields);
        }
        if(count(Session::get('_old_input')['extra_fields']) > 0){
            $extra_fields = Session::get('_old_input')['extra_fields'];
            $json_extra = json_encode($extra_fields);
        }

        $fields = hasFields([2],['select'=>['col-sm'=>5],'input'=>['col-sm'=>5],'textarea'=>['col-sm'=>9]], $extra_fields);
        return view('admin.articles.edit',compact('item','users','fields','parent','catid','image_gallery','extra_fields','checked_cats','json_extra'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ArticleRequest $request,$id)
    {

        $article = Article::findOrFail($id);
        $input = $request->all();
        $input['img'] = (!empty($request->input('image')[0]['img'])) ? $request->input('image')[0]['img'] : '';
        $request->replace($input);
        $article->update($request->all());
        $article->updateCat(['cat'=>$request->input('cat'),'id'=>$id]);
        //dump($request->input('image'));
        $article->images()->delete();
        foreach($request->input('image') as $img){
            $article->images()->create(array_add($img,'article_id',$id));
        }

        flash()->success(trans('articles.article_updated'));
        return redirect(action('Admin\ArticlesController@index'));

    }



    public function event(Request $request,Article $article){
        $this->post = $article->create($request->all());
        $this->post->categories()->attach($request->input('cat'));
        return 1;
    }

    public function getEvents(Request $request){
        $start = date('Y-m-d H:i:s',$request->input('start'));
        $end = date('Y-m-d H:i:s',$request->input('end'));
        $article = Article::select('title','body','user_id','published_at as start','finished_at as end')->bycatslug('events')->where('published_at','>=',$start)->where('finished_at','<=',$end)->get();
        $json = array();
        if(count($article) > 0):
            $i=0;foreach($article as $item):
            $json[$i]['title'] = $item->title;
            $json[$i]['body'] = '<br><p>'.$item->body.'</p>';
            $json[$i]['start'] = badeStartDate(strtotime($item->start));
            $json[$i]['end'] = badeEndDate(strtotime($item->end));
            if(strtotime($item->end) < time()){
                $json[$i]['color'] = "#CCC";
            }
            if(strtotime($item->start) > time()){
                if($item->user_id == $request->user()->id){
                    $json[$i]['color'] = "green";
                }else{
                    $json[$i]['color'] = "#C09";
                }

            }
            $i++;
        endforeach;
            if(count($json) > 0){
                return json_encode($json,JSON_UNESCAPED_UNICODE);
            }else{
                return 0;
            }
        endif;
        return 0;

    }
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($cat,$sid)
	{

        $item = Article::select('id','title','body')->where('id',$sid)->orWhere('slug',$cat.'/'.$sid)->orWhere('slug',$sid)->getarticlecat()->first();
        $images = $item->images()->get();

        //DB::table('articles')->where('id',$sid)->orWhere('slug',$sid)->increment('view',1);
        return view('admin.articles.show',compact('item','images'));
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
        return trans('articles.article_removed');
	}


    public function filter(Request $request){
            filter_cookies($request,'a_');
            return redirect(action('Admin\ArticlesController@index'));
    }

    public function active($id,Article $article){
        //Cache::flush();
        $article = $article->findOrFail($id);
        return trans('Article #'.$id.' is '.$article->articleStatus($article).' now');
    }

    public function getCats(Request $request){
        $id = $request->input('id');
        $news_id = ($request->input('news_id')) ? $request->input('news_id') : 0;
        $cats = get_cat_by_parent($id);
        $item = ($news_id > 0) ? Article::findOrFail($news_id) : [];
        $checked_cats = explode(',',$request->input('checked'));
        $checked = '';
        return view('admin.articles.cats',compact('cats','item','checked','news_id','checked_cats'));
    }


    public function getFields(Request $request){
        //$item = ($request->input('news_id') > 0) ? Article::findOrFail($request->input('news_id')) : '';
        $extra_fields = false;
        if($request->input('extra_fields') != "" && $request->input('extra_fields') !== false){
            $extra_fields = get_object_vars(json_decode(json_encode($request->input('extra_fields'))));
        }

        $fields = ($request->input('news_id') > 0) ? hasFields([$request->input('id')],['select'=>['col-sm'=>5],'input'=>['col-sm'=>9],'textarea'=>['col-sm'=>9]],$extra_fields) : hasFields([$request->input('id')],['select'=>['col-sm'=>5],'input'=>['col-sm'=>9],'textarea'=>['col-sm'=>9]],$extra_fields);

        if(!empty($fields)){
            return '<div class="extra_fields_'.$request->input('id').'">'.$fields.'</div>';
        }else{
            return 1;
        }

    }


    public function brightCove(Request $request){
        if($request->input('filter_video') == "Filter" or $request->input('reset_video') == "Reset"){
            $request->session()->put('search_video',$request->input('search_video'));
            $request->session()->put('search_type',$request->input('type'));
        }
        $search_video = filter_request($request,'search_video');
        $search_type = filter_request($request,'type');
        $selected = 0;
        if(!empty($search_video)){
            if($search_type == 1){
                $selected = 1;
                $search_sql = '&any=display_name:'.str_replace(' ','%20',$search_video);
            }elseif($search_type == 2){
                $selected = 2;
                $search_sql = '&any=tag:'.str_replace(' ','%20',$search_video);
            }else{
                $search_sql = '&any='.str_replace(' ','%20',$search_video);
            }
        }else{
            $search_sql = '';
        }
        $page_number = ($request->input('page') > 0) ? $request->input('page') : 0;
        $url = 'http://api.brightcove.com/services/library?command=search_videos'.$search_sql.'&page_size=15&video_fields=id%2Cname%2CshortDescription%2Ctags%2CthumbnailURL&media_delivery=default&sort_by=PUBLISH_DATE&sort_order=ASC&page_number='.$page_number.'&get_item_count=true&callback=BCL.onSearchResponse&token=_FkpjudFGAdmchAxwVgh1XKZ88KPeC9itvIsTpEJHTrqAKOYA1P1Sg..';
        $content = file_get_contents($url) or die('can`t connect to brightcove server!');
        $content = str_replace('BCL.onSearchResponse(','[',$content);
        $content = str_replace(');',']',$content);
        $content = json_decode($content);
        $paging = new LengthAwarePaginator('', $content[0]->total_count, $content[0]->page_size, $content[0]->page_number,['class'=>'pagination']);
        $type = ['All','Names and description','Tags'];
        //dump($request->input('search'));

        //dump($paging);
        return view('admin.brightcove.index',compact('content','paging','type','search_video','selected'));
    }


    /**
     * get tags ajax
     */

    public function getAjaxTags(Request $request){
        $tags = Article::select('meta_key')->where('meta_key','LIKE','%'.$request->input('text').'%')->take(20)->get();
        $results = array();
        $output ='<ul>';

        if(count($tags) > 0){
            foreach($tags as $tag){
                $t = explode(', ',$tag->meta_key);
                $result = preg_grep('~' . $request->input('text') . '~', $t);
                $result = reset($result);
                if(!empty($result)){
                    $results[] = $result;
                }
            }
            if(count($results) > 0){
                foreach(array_unique($results) as $res){
                    $output .= '<li data-name="'.$res.'">'.$res.'</li>';
                }
            }
        }else{
            return 0;
        }
        $output .='</ul>';
        return $output;

    }

    public function sortNews()
    {
        $admin = true;

        $xmlPlaylist = Cache::get('currentPlaylist');
        //getting news list on front page
        $news = Cache::remember('news_'.App::getLocale(),5,function(){
            return Article::select('id','title','frontpage_title','head','body','slug','extra_fields','published_at','img', 'pos')->lang(App::getLocale())->orderBy('published_at','desc')->published()->bycatslug('news')->take(10)->get();
        });

        $news = sortByPos($news);
        
        set_globals(['title'=>get_setting('site_title')]);

        return view('pages.front.index', compact('xmlPlaylist','news','events', "admin"));
    }


    public function saveOrder(Request $request)
    {
        $list = json_decode($request->orders, true);

        for($i = 0; $i < count($list); $i++)
        {
            Article::where("id", $list[$i])->update(["pos" => $i]);
        }

        if ( Cache::has('news_'.App::getLocale()) ) {
            Cache::forget('news_'.App::getLocale());
        }

        return redirect()->back()->with("msg", "Articles order has been changed");
    }


}
