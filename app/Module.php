<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['title','name','controller','trans','icon','status','sort'];
    protected $table = 'modules';
    public function moduleStatus($module){
        if($module->status > 0)
        {
            $module->update(['status'=>'0']);
            return 'unpublished';
        }else{
            //Article::where('status','=','1')->update(['status'=>'0']);
            $module->update(['status'=>'1']);
            return 'published';
        }
    }
}
