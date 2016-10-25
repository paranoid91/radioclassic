<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name','value','lang','type','target'],$settings;


    public function updateSettings($request,$array=array()){
            if(count($array) > 0){
                foreach($array as $key=>$item){
                    $this->where('name',$item)->where('lang',\App::getLocale())->update(['value'=>$request->input($item)]);
                }
                return true;
            }
    }


    public function show($name){
        if(count($this->settings) > 0){
            foreach($this->settings as $item){
                if($item->name == $name){
                    return $item->value;
                }
            }
        }

    }
}
