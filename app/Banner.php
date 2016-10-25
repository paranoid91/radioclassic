<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title','url','banner','size_x','size_y','published_at','finished_at','lang'];

    protected $table = 'banners';

    protected $id,$data;

    /**
     * @param $date
     */
    public function setPublishedAtAttribute($date){
        $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y H:i',$date);
    }

    public function setFinishedAtAttribute($date){
        $this->attributes['finished_at'] = Carbon::createFromFormat('d/m/Y H:i',$date);
    }



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

    public function updateCat(array $data){
        $cat = $this->find($data['id']);
        $cat->categories()->detach();
        if(count($data['cat']) > 0){
            foreach($data['cat'] as $id):
                $cat->categories()->attach($id);
            endforeach;
        }
    }


    public function scopeBannerCat($query,$id){
        $this->id = $id;
        $query->with(['categories' => function ($q) {
            $q->where('cat_id',$this->id);
        }]);
        $query->whereHas('categories',function($q){
            $q->where('cat_id',$this->id);
        });
    }

    public function scopeBannerPosition($query,$data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->where('categories.slug',$this->data);
        }]);
        $query->whereHas('categories',function($q){
            $q->where('categories.slug',$this->data);
        });
    }

    public function scopeBannerDate($query){
        $query->where('published_at','<',Carbon::now())->where('finished_at','>',Carbon::now());
    }
}
