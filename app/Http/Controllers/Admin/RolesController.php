<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use App\Http\Requests\RolesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller {

    protected $perms = [],$auth;

    /**
     * @var string
     */
    protected $moduleName= 'roles';


    /**
     * CastsController constructor.
     */
    public function __construct(){
        $this->middleware('roles',['except'=>get_role_permissions($this->moduleName)]); // add roles permissions
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $roles = (Auth::user()->hasRole('Super Admin')) ? Role::latest()->paginate(get_setting('pagination_num')) : Role::latest()->nouser(['Guest','Super Admin'])->paginate(get_setting('pagination_num'));
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $modules = get_module_names(['modules']);
        $role = '';
        return view('admin.roles.create',compact('modules','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(RolesRequest $request)
    {

        Role::create($request->all());

        flash()->success(trans('groups.added'));

        return redirect(action('Admin\RolesController@index'));
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
        $modules = get_module_names(['modules']);
        $role = Role::findOrFail($id);
        return view('admin.roles.edit',compact('role','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(RolesRequest $request,$id)
    {
        if(!$request->input('permissions')):
            $request->replace(['permissions'=>'']);
        endif;
        $role = Role::findOrFail($id);
        $role->update($request->all());

        flash()->success(trans('groups.updated'));

        return redirect(action('Admin\RolesController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return trans('groups.removed');
    }

}
