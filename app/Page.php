<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $table = 'articles';


    protected $fillable = [
        'user_id',
        'title',
        'body',
        'slug',
        'meta_key',
        'meta_desc',
        'status',
        'lang'
    ];




    protected $request,$from,$to,$data,$slug;


    /**
     * @param $query
     * @param array $data
     */
    public function scopeOrderCat($query,array $data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->whereIn('parent',$this->data);
        }]);
        $query->whereHas('categories',function($q){
            $q->whereIn('parent',$this->data);
        });
    }





    /**
     * @param $slug_name
     */
    public function setSlugAttribute($slug){

        if(empty($slug)){
            $this->slug = Str::generate_ge($this->attributes['title']);
            $slug = Page::where('slug','=',$this->slug)->pluck('slug');
            $this->attributes['slug'] = (empty($slug)) ? $this->slug : $this->slug.'-'.str_random(5);
        }else{
            if(isset($_REQUEST['_method']) == 'PATCH'){
                $this->slug = Str::generate_ge($slug);
                $slug = Page::where('slug','=',$this->slug)->count();
                $this->attributes['slug'] = ($slug <= 1) ? $this->slug : $this->slug.'-'.str_random(5);
            }else{
                $this->slug = Str::generate_ge($slug);
                $slug = Page::where('slug','=',$this->slug)->pluck('slug');
                $this->attributes['slug'] = (empty($slug)) ? $this->slug : $this->slug.'-'.str_random(5);
            }

        }

    }

    /**
     * Articles is owned by user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(){
        return $this->belongsToMany('App\Cat')->withTimestamps();
    }


    /**
     * @param array $data
     */
    public function addCat(array $data){
        $cat = $this->find($data['id']);
        $cat->categories()->attach($data['cat']);
    }

    public function setExtraFieldsAttribute($query){
        $this->attributes['extra_fields'] = serialize($query);
    }


}
