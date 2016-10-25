<?php namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Article extends Model {

	protected $fillable = [
        'user_id',
        'type',
        'title',
        'frontpage_title',
        'social_media_title',
        'head',
        'body',
        'slug',
        'meta_key',
        'meta_desc',
        'img',
        'author',
        'status',
        'menu_builder',
        'lang',
        'extra_fields',
        'published_at',
        'finished_at'
    ];

    protected  $dates = ['published_at'];


    protected $request,$from,$to,$data,$slug,$prefix;
    /**
     * @param $query
     */
    public function scopePublished($query){
        $query->where('published_at','<=',Carbon::now())->where('status',1);
    }

    public function scopeFinished($query){
        $query->where('finished_at','>',Carbon::now())->where('status',1);
    }

    public function scopeNoThis($query,$id){
        $query->where('id','<>',$id);
    }

    public function scopeLang($query,$lang){
        $query->where('lang',$lang);
    }

    /**
     * @param $query
     * @param array $data
     */
    public function scopeOrderCat($query,array $data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->whereIn('parent',$this->data)->get(['categories.name','categories.slug']);
        }]);
        $query->whereHas('categories',function($q){
            $q->whereIn('parent',$this->data);
        });
    }

    public function scopeGetCat($query,$data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->where('parent',$this->data)->get(['categories.name','categories.slug']);
        }]);
        $query->whereHas('categories',function($q){
            $q->where('parent',$this->data);
        });
    }

    public function scopeOrderAll($query,array $data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->whereIn('categories.id',$this->data)->select('categories.id','categories.name','categories.slug');
        }]);
        $query->whereHas('categories',function($q){
            $q->whereIn('categories.id',$this->data);
        });
    }

    public function scopeGetOne($query,$data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->where('categories.id',$this->data)->select(['categories.id','categories.name','categories.slug']);
        }]);
        $query->whereHas('categories',function($q){
            $q->where('categories.id',$this->data);
        });
    }

    public function scopeByCatSlug($query,$data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->where('categories.slug',$this->data)->select(['categories.id','categories.name','categories.slug']);
        }]);
        $query->whereHas('categories',function($q){
            $q->where('categories.slug',$this->data);
        });
    }

    public function scopeByCatSlugs($query,$data=array()){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->whereIn('categories.slug',$this->data)->select(['categories.id','categories.name','categories.slug']);
        }]);
        $query->whereHas('categories',function($q){
            $q->whereIn('categories.slug',$this->data);
        });
    }


    public function scopeGetArticleCat($query){
        $query->with(['categories'=>function($q){
            $q->select('categories.id');
        }]);
        $query->whereHas('categories',function($q){

        });
    }

    public function scopeGetOneFirst($query,$data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->where('categories.id',$this->data)->get(['categories.id','categories.name','categories.slug'])->first();
        }]);

    }

    public function scopeMainCat($query,array $data){
        $this->data = $data;
        $query->with(['categories' => function ($q) {
            $q->whereIn('cat_id',$this->data)->get(['categories.id','categories.name','categories.slug']);
        }]);
        $query->whereHas('categories',function($q){
            $q->whereIn('cat_id',$this->data);
        });
    }

    public function scopeSearch($query,$data){
        $query->where('title','LIKE','%'.$data.'%')->orWhere('body','LIKE','%'.$data.'%');
    }



    /**
     * @param $query
     * @param $request
     */
    public function scopeFilter($query,$request,$prefix){
        $this->request = $request;
        $this->prefix = $prefix;

        //filter by category
        if(filter_request($this->request,$this->prefix.'cat') <> 0){
            if(filter_request($this->request,$this->prefix.'cat') > 2){
                $query->whereHas('categories',function($q){
                    $q->where('cat_id',filter_request($this->request,$this->prefix.'cat'));
                });
            }
            if(filter_request($this->request,$this->prefix.'cat') == 2){
                $query->whereHas('categories',function($q){
                    $q->where('parent',filter_request($this->request,$this->prefix.'cat'));
                });
            }

        }

        //filter by type
        /*
        if(!empty(filter_request($this->request,$this->prefix.'type'))){
            $query->where('type','=',filter_request($this->request,$this->prefix.'type'));
        }*/

        //filter by author
        if(filter_request($this->request,$this->prefix.'author') <> null){
            $query->where('author','like',filter_request($this->request,$this->prefix.'author').'%');
        }

        //filter by date
        if(filter_request($this->request,$this->prefix.'from') <> null or filter_request($this->request,$this->prefix.'to') <> null){
            if(filter_request($this->request,$this->prefix.'from') <> null){
                $this->to = (!filter_request($this->request,$this->prefix.'to')) ? Carbon::now() : Carbon::createFromFormat('d/m/Y H:i',filter_request($this->request,$this->prefix.'to'));
                $this->from = Carbon::createFromFormat('d/m/Y H:i',filter_request($this->request,$this->prefix.'from'));
                $query->whereBetween('published_at',[$this->from,$this->to]);
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
        return $this->belongsToMany('App\Cat');
    }


    /**
     * @return article Images
     */
    public function images(){
        return $this->belongsToMany('App\Image');
    }

    /**
     * @param array $data
     */
    public function addCat(array $data){
        $cat = $this->find($data['id']);
        if(count($data['cat']) > 0){
            foreach($data['cat'] as $id):
                $cat->categories()->attach($id);
            endforeach;
        }
    }

    /**
     * @param array $data
     */
    public function updateCat(array $data){
        $cat = $this->find($data['id']);
        $cat->categories()->detach();
        if(count($data['cat']) > 0){
            foreach($data['cat'] as $id):
                $cat->categories()->attach($id);
            endforeach;
        }
    }

    /**
     * update images
     */
    public function updateImages(array $data){
        //dump($data['image']);
        $image = $this->find($data['id']);

        if(count($data['image']) > 0){
            for($i=0;$i<count($data['image']);$i++):
                $image->images()->attach('',['article_id'=>$data['id'],'image_id'=>$data['image_id']]);
            endfor;
        }
    }

    /**
     * @param $date
     */
    public function setPublishedAtAttribute($date){
        $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y H:i',$date);
    }
    public function setFinishedAtAttribute($date){
        $this->attributes['finished_at'] = Carbon::createFromFormat('d/m/Y H:i',$date);
    }
    public function setExtraFieldsAttribute($query){
        $this->attributes['extra_fields'] = serialize($query);
    }


    /**
     * @param $slug_name
     */
    public function setSlugAttribute($slug){

        if(empty($slug)){
            $this->slug = Str::generate_ge($this->attributes['title']);
            $slug = Article::where('slug','=',$this->slug)->pluck('slug');
            $this->attributes['slug'] = (empty($slug)) ? $this->slug : $this->slug.'-'.str_random(5);
        }else{
            if(isset($_REQUEST['_method']) == 'PATCH'){
                $this->slug = Str::generate_ge($slug);
                $slug = Article::where('slug','=',$this->slug)->count();
                $this->attributes['slug'] = ($slug <= 1) ? $this->slug : $this->slug.'-'.str_random(5);
            }else{
                $this->slug = Str::generate_ge($slug);
                $slug = Article::where('slug','=',$this->slug)->pluck('slug');
                $this->attributes['slug'] = (empty($slug)) ? $this->slug : $this->slug.'-'.str_random(5);
            }

        }

    }

    public function setCatAttribute($cat){
        if(is_array($cat)){
            $this->attributes['cat'] = serialize($cat);
        }else{
            $this->attributes['cat'] = $cat;
        }

    }


    public function articleStatus($article){
        if($article->status > 0)
        {
            $article->update(['status'=>'0']);
            return 'unpublished';
        }else{
            //Article::where('status','=','1')->update(['status'=>'0']);
            $article->update(['status'=>'1']);
            return 'published';
        }
    }


}
