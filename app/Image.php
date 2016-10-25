<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['article_id','title','alt','img','source','author','published_at','slug','meta_key','meta_desc','status','lang'];

/*
    public function setImagesAttribute($img){
        $this->attributes['images'] = serialize($img);
    }

    public function setImgTitleAttribute($img_title){
        $this->attributes['img_title'] = serialize($img_title);
    }
*/
    /**
     * @param $date
     */
    public function setPublishedAtAttribute($date){
        $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y H:i',$date);
    }


    /**
     * @param $slug_name
     */
    public function setSlugAttribute($slug){

        if(empty($slug)){
            $this->slug = Str::generate_ge($this->attributes['title']);
            $slug = Image::where('slug','=',$this->slug)->pluck('slug');
            $this->attributes['slug'] = (empty($slug)) ? $this->slug : $this->slug.'-'.str_random(5);
        }else{
            if(isset($_REQUEST['_method']) == 'PATCH'){
                $this->slug = Str::generate_ge($slug);
                $slug = Image::where('slug','=',$this->slug)->count();
                $this->attributes['slug'] = ($slug <= 1) ? $this->slug : $this->slug.'-'.str_random(5);
            }else{
                $this->slug = Str::generate_ge($slug);
                $slug = Image::where('slug','=',$this->slug)->pluck('slug');
                $this->attributes['slug'] = (empty($slug)) ? $this->slug : $this->slug.'-'.str_random(5);
            }

        }

    }


    /**
     * @param $query
     * @param $request
     */
    public function scopeFilter($query,$request,$prefix){
        $this->request = $request;
        $this->prefix = $prefix;

        if(filter_request($this->request,$this->prefix.'author') <> null){
            $query->where('author','like',filter_request($this->request,$this->prefix.'author').'%');
        }
        if(filter_request($this->request,$this->prefix.'from') <> null or filter_request($this->request,$this->prefix.'to') <> null){
            if(filter_request($this->request,$this->prefix.'from') <> null){
                $this->to = (!filter_request($this->request,$this->prefix.'to')) ? Carbon::now() : Carbon::createFromFormat('d/m/Y H:i',filter_request($this->request,$this->prefix.'to'));
                $this->from = Carbon::createFromFormat('d/m/Y H:i',filter_request($this->request,$this->prefix.'from'));
                $query->whereBetween('published_at',[$this->from,$this->to]);
            }
        }

    }


    public function scopePublished($query){
        $query->where('published_at','<=',Carbon::now());
    }

    public function imageStatus($image){
        if($image->status > 0)
        {
            if($image->update(['status'=>'0'])){
                return 'unpublished';
            }
        }else{
            //Article::where('status','=','1')->update(['status'=>'0']);
            $image->update(['status'=>'1']);
            return 'published';
        }
    }

    /**
     * a images can have article
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(){
        return $this->hasOne('App\Article');
    }
}
