<?php namespace App\Http\Controllers\Admin;

use App\Cat;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class CategoriesController extends Controller {
    protected $perms = [],$auth;
	/**
	 * @var string
	 */
	protected $moduleName= 'categories';


	/**
	 * CastsController constructor.
	 */
	public function __construct(){
		$this->middleware('roles',['except'=>get_role_permissions($this->moduleName)]); // add categories permissions
		$this->middleware('catAdmin',['only'=>'edit','update']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Cat $category)
	{
        $categories = $category->orderBy('sort')->get();
        return view('admin.categories.index',compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Cat $category)
	{
        $categories = $category->select('id','name','parent')->orderBy('name')->get();
		return view('admin.categories.create',compact('categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CatRequest $request, Cat $category)
	{
        Cache::forget('cats');
        $category->create($request->all());
        flash()->success(trans('sections.added'));
        return redirect(action('Admin\CategoriesController@index'));
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
	public function edit($id, Cat $cats)
	{
        $cat = $cats->findOrFail($id);
        $categories = $cats->select('id','name','parent')->orderBy('name')->nothis($id)->get();


        return view('admin.categories.edit',compact('cat','categories'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CatRequest $request,Cat  $category,$id)
	{
        //return dump($request->input('_method'));
        $category->findOrFail($id)->update($request->all());
        Cache::forget('cats');
        flash()->success(trans('sections.updated'));
        return redirect(action('Admin\CategoriesController@index'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        Cache::forget('cats');
        Cat::findOrFail($id)->delete();
        Cat::where('parent',$id)->delete();
        return trans('sections.section') . ' #'.$id.' ' . trans('sections.successfully_removed');
	}


    public function sort(Request $request,$id){
        Cache::forget('cats');
        $data = $request->input('sort');
        Cat::findOrFail($id)->update(['sort'=>$data]);
        return trans('sections.sort_section') . ' #'.$id.' '. trans('sections.sort_changed') .' '.$data .' '. trans('sections.sort_position');
    }






}
