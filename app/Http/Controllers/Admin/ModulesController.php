<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ModuleRequest;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModulesController extends Controller
{
    protected $perms = [], $auth, $post, $children = [];

    public function __construct(){
        /**
         * Middlewares
         */
        $this->middleware('noAdmin');
        $this->middleware('language');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Module $module)
    {

        $modules = $module->select('id','title','name','controller','status')->orderBy('sort','asc')->paginate(get_setting('pagination_num'));

        return view('admin.modules.index',compact('modules'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request,Module $module)
    {
        $module->create($request->all());
        flash()->success(trans('all.module_added'));
        return redirect(action('Admin\ModulesController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $module = Module::findOrFail($id);
        return trans('Module #'.$id.' is '.$module->moduleStatus($module).' now');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return view('admin.modules.edit',compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->update($request->all());
        flash()->success(trans('all.module_edited'));
        return redirect(action('Admin\ModulesController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Module::findOrFail($id)->delete();
        return trans('all.module_removed');
    }


    public function sort(Request $request,$id){
        for($i=0;$i<count($request->input('items'));$i++){
           $module = Module::findOrFail($request->input('items')[$i]);
           $module->update(['sort'=>$i]);
        }
        return 1;
    }
}
