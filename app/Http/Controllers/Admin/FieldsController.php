<?php

namespace App\Http\Controllers\Admin;

use App\Cat;
use App\Field;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FieldsController extends Controller
{

    /**
     * construct Fields
     * middlewares
     */
    function __construct(){
        $this->middleware('noAdmin');
        $this->middleware('language');
    }

 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $cat = Cat::select('id','name','parent')->where('id',$id)->orderBy('name')->first();

       $fields = Field::select('id','cat_id','value','trans','tag','type')->where('cat_id',$cat->id)->get();

       return view('admin.fields.index',compact('cat','fields'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return int|string
     */
    public function store(Request $request,$id){
        if(count($request->input('field_trans')) > 0){
            $values = array();
            for($i=0;$i<count($request->input('field_trans'));$i++){
                $values['trans'][$i] = $request->input('field_trans')[$i];
                $values['val'][$i] = $request->input('val')[$i];
            }
            $values = serialize($values);
        }else{
            $values = "";
        }
        if($request->input('trans') != "" && $request->input('tag') != ""){
            Field::insert(['cat_id'=>$id,'value'=>$values,'trans'=>$request->input('trans'),'tag'=>$request->input('tag'),'type'=>$request->input('type')]);
            return 'Field has been added successfully!';
        }else{
            return 12;
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return int|string
     */
    public function update(Request $request,$id){
        if(count($request->input('field_trans')) > 0){
            $values = array();
            for($i=0;$i<count($request->input('field_trans'));$i++){
                $values['trans'][$i] = $request->input('field_trans')[$i];
                $values['val'][$i] = $request->input('val')[$i];
            }
            $values = serialize($values);
        }else{
            $values = "";
        }
        if($request->input('trans') != "" && $request->input('tag') != ""){
            $field = Field::findOrFail($id);
            $field->update(['value'=>$values,'trans'=>$request->input('trans'),'tag'=>$request->input('tag'),'type'=>$request->input('type')]);
            return 'Field has been updated successfully!';
        }else{
            return 12;
        }
    }


    /**
     * @param $id
     * @return int|string
     */
    public function drop($id){
        $field = Field::findOrFail($id)->delete();
        if($field){
            return 'Field has been removed successfully!';
        }else{
            return 12;
        }
    }
}
