<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PollRequest;
use App\Poll;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Response;


class PollsController extends Controller
{


    /**
     * @var string
     */
    protected $moduleName= 'polls';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName,['active','vote'])]); // add polls permissions
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $polls = Poll::where('lang',App::getLocale())->latest('published_at')->parent([0])->paginate(get_setting('pagination_num'));

        return view('admin.polls.index',compact('polls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PollRequest $request)
    {
        $poll = Poll::create($request->all());

        return redirect(action('Admin\PollsController@edit',$poll->id));
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
        $poll = Poll::findOrFail($id);
        $children = Poll::where('parent_id','=',$id)->get();
        return view('admin.polls.edit',compact('poll','children'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,PollRequest $request,Poll $polls)
    {
        $poll = $polls->findOrFail($id);

        $poll->update($request->all());
        if( count($request->input('answer')) > 0){
            $polls->where('parent_id','=',$id)->delete();
            foreach($request->input('answer') as $answer){
                   $vote = $polls->create(['title'=>$answer,'parent_id'=>$id]);
                   DB::table('votes')->insert(['poll_id'=>$vote->id,'parent_id'=>$id,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            }
        }
        //$article->updateCat(['cat'=>$request->input('cat'),'id'=>$id]);
        flash()->success(trans('polls.updated'));
        return redirect(action('Admin\PollsController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Poll::findOrFail($id)->delete();

        return trans('polls.removed');
    }

    public function active($id,Poll $polls){

        $poll = $polls->findOrFail($id);

        return trans('Poll #'.$id.' is '.$polls->pollStatus($poll).' now');
    }

    public function vote(Request $request){

        $ip = $request->getClientIp();
        $cookie = md5($request->input('parent_id'));
        $voteCookie = Cookie::forever('vote', $cookie);

        if(DB::table('votes')->insert(['poll_id'=>$request->input('id'),'parent_id'=>$request->input('parent_id'),'ip'=>ip2long($ip),'cookie'=>$cookie,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()])){
            return response('success')->withCookie($voteCookie);
        }else{
            return 'error';
       }
    }

}
