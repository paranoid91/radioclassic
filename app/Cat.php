<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;
use Illuminate\Support\Str;

class Cat extends Model {

	protected $fillable = ['parent','name','slug','sort'];



    protected $table = 'categories';

    protected $method;

    protected static $option,$list,$data;

    protected $info;
    /**
     * @param $query
     */


    public function articles(){
        return $this->hasMany('App\Article');
    }

    public function banners(){
        return $this->hasMany('App\Banner');
    }

    public function pages(){
        return $this->hasMany('App\Page');
    }

    public function setParentIdAttribute(){
        return false;
    }


    public function setSlugAttribute($slug_name){

        if(empty($slug_name)){
            $this->info = Str::generate_ge($this->attributes['name']);
            $slug_name = Cat::where('slug','=',$this->info)->pluck('slug');
            $this->attributes['slug'] = (empty($slug_name)) ? $this->info : $this->info.'-'.str_random(5);
        }else{
            if(isset($_REQUEST['_method']) == 'PATCH'){
                $this->info = Str::generate_ge($slug_name);
                $slug_name = Cat::where('slug','=',$this->info)->count();
                $this->attributes['slug'] = ($slug_name <= 1) ? $this->info : $this->info.'-'.str_random(5);
            }else{
                $this->info = Str::generate_ge($slug_name);
                $slug_name = Cat::where('slug','=',$this->data)->pluck('slug');
                $this->attributes['slug'] = (empty($slug_name)) ? $this->info : $this->info.'-'.str_random(5);
            }

        }

    }



    public function scopeNomain($query){
        $query->whereNotIn('slug',['articles','pages','categories']);
    }


    public function scopePost($query,$id){
        $query->where('parent','=',$id);
    }
    public function scopePosts($query,array $id){
        $query->whereIn('parent',$id)->orWhereIn('id',$id);
    }

    public function scopeSlug($query,$slug){
        $query->where('slug','=',$slug);
    }

    public function scopePostExtra($query,array $data){
        $query->where('id',$data['id'])->orWhereIn('parent',$data['parent']);
    }

    public function scopePostParent($query,$id){
        $query->where('parent','=',$id)->orWhere('id','=',$id);
    }

    public function scopePages($query){
        $query->where('parent','=',1);
    }

    public function scopeCats($query){
        $query->where('parent','=',3);
    }

    public function scopeNothis($query,$id){
        $query->where('id','<>',$id);
    }






}
