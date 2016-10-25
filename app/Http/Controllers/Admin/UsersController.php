<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    protected $users;
    /**
     * @var string
     */
    protected $moduleName= 'users';


    /**
     * UsersController constructor.
     * @param User $users
     */
    public function __construct(User $users){
        $this->users = $users;
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName,['frontEdit','getAjaxUserName'])]); // add users permissions
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->users->orderrole(['Super Admin'])->paginate(get_setting('pagination_num'));
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Role $role)
    {
        $roles = array();
        $role = (Auth::user()->hasRole(['Super Admin','Admin'])) ? $role->nouser(['Super Admin','Guest'])->select('id','name')->get()->toArray() : '';
        foreach($role as $r){
            $roles[$r['id']] = $r['name'];
        }
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->users;
        $create = $user->create($request->all());
        $user->addRole(['user_id'=>$create->id,'role_id'=>$request->input('role'),'default'=>3]);
        flash()->success(trans('all.user_added'));
        return redirect(action('Admin\UsersController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Edit user on front end.
     *
     * @param  int  $id
     * @return Response
     */
    public function frontEdit($id)
    {
      return 'hey';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Role $role,$id)
    {
        $roles = array();
        $role = (Auth::user()->hasRole(['Super Admin','Admin'])) ? $role->nouser(['Super Admin','Guest'])->select('id','name')->get() : '';
        foreach($role as $r){
            $roles[$r['id']] = $r['name'];
        }
        $user = $this->users;
        $user = $user->orderrole(['Super Admin'])->findOrFail($id);
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UserRequest $request,$id)
    {
        $user = $this->users;
        $user = $user->findOrFail($id);
        $user->update($request->all());
        $user->updateRole(['user_id'=>$id,'id'=>$request->input('role')]);
        flash()->success(trans('all.user_updated'));
        return redirect(action('Admin\UsersController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return trans('all.account') .  ' #'.$id.' '. trans('all.successfuly_removed');
    }

    /**
     * get Ajax User
     */

    public function getAjaxUserName(Request $request){
        $users = User::select('name','id')->username($request->input('text'))->take(10)->get();
        //$users = array_pluck($users,'id');
        $output ='<ul>';
        if(count($users) > 0){
            foreach($users as $user){
                foreach($user->details as $u){
                    $output .= '<li data-name="'.$user->name.'">'.$u->full_name.'</li>';
                }
            }
        }else{
            return 0;
        }

        $output .='</ul>';
        return $output;

    }
}
