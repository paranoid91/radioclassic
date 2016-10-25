<?php
/**
 * Created by IT-SOLUTIONS.
 * IS CMS
 * User: Vati Child
 * Date: 3/7/15
 * Time: 11:09 PM
 */



use Illuminate\Support\Facades\Cookie;
use App\Services\weather;
use App\Banner;

$registry = array();
/**
 * @param int $min ქეშირების დრო წუთებში
 * @param string $cat კატეგორიის ID ან Slug
 * @param array $value დამატებითი ელემენტები ნავიგაციაში მაგ:(მთავარი,ჩვენ შესახებ)
 * @param array $options დამატებითი ელემენტები <ul> თეგში
 * @param int $max ელემენტების რაოდენობა ნავიგაციაში.
 * @return string მენიუ / ნავიგაცია (კატეგორია, სექციების მიხედვით)
 */

if(! function_exists('horizontalMenuWidget')){
    function horizontalMenuWidget($min, $cat, $value=array(), $options = array(), $max = 0){
        global $registry;
        $ul = false;
        $registry['cat'] = $cat;

        if(count($options) > 0){
            foreach($options as $key=>$op){
                $ul .= $key.'='.$op;
            }
        }


        $entry = Cache::remember('rubrics', $min, function() {
             global $registry;
            if(is_numeric($registry['cat']) and !ctype_alpha($registry['cat'])){
                return \App\Cat::orderBy('sort','asc')->posts($registry['cat'])->get();
            }else{
                $slug = \App\Cat::select('id')->where('slug',$registry['cat'])->first();
                return  \App\Cat::orderBy('sort','asc')->posts($slug->id)->get();
            }
        });

        $output = '<ul '.$ul.'>';
        if(count($value) > 0){
            foreach($value as $key=>$v){
                $output .= '<li><a href="'.$key.'">'. $v .'</a></li>';
            }
        }


        $i=0;
        if($max > 0){
            foreach ($entry as $item): $i++;
                if($i <= $max):
                    $output .= '<li><a href="/cat/' . $item->slug . '">' . $item->name . '</a></li>';
                endif;
            endforeach;
            if(count($entry) > $max){
                $output .= '<li class="more"><a>'. trans('all.more') .' <i class="fa fa-caret-right"></i></a><ul>';
                $i=0;foreach ($entry as $item): $i++;
                    if($i > $max):
                        $output .= '<li><a href="/cat/'.$item->slug.'">'. $item->name .'</a></li>';
                    endif;
                endforeach;
                $output .= '</ul></li>';
            }
        }else{
            foreach ($entry as $item): $i++;
                $output .= '<li><a href="/cat/' . $item->slug . '">' . $item->name . '</a></li>';
            endforeach;
        }


        $output .= '</ul>';
        return $output;
    }

}


if(! function_exists('articlesWidget')){
    function articlesWidget($min){

        $output = '';

        $entry = Cache::remember('articles_list',$min,function(){
            return \App\Article::latest('published_at')->where('status',1)->select('news_id','staties_id','img','title','slug','published_at')->getcat(2)->take(5)->get();
        });
        if(count($entry) > 0){
        $output .= '<div class="articles-list"><div class="rub-title-left"><a href="/cat/articles"><div style="margin:0 !important"><h3>სტატიები</h3></div><span>ყველა სტატია</span></a></div><ul>';
        foreach($entry as $item):
            $output .='<li> <div>
                        <a href="'.get_articles_url($item->staties_id,$item->slug).'"><img src="'.get_news_small_img($item->img).'" title="'.$item->title.'"><small>'.date('H:i',strtotime($item->published_at)).'</small></a>
                    </div>
                    <div>
                    <a href="'.get_articles_url($item->staties_id,$item->slug).'">
                        <h4>'.$item->title.'</h4>
                    </a>
                </div>
                    </li>';
        endforeach;
        $output .='</ul></div>';
        }
        return $output;
    }

}


if(! function_exists('imagesWidget')){
    function imagesWidget($min){


        $entry = Cache::remember('images',$min,function(){
            return \App\Image::latest('published_at')->select('images','img_title')->first();
        });

        return $entry;
    }
}


if(! function_exists('pollWidget')){
    function pollWidget($min){
        global $registry;
        $output = '';
        //$entry = Cache::remember('poll',$min,function() {
            $entry = \App\Poll::select('id', 'title')->where('status', 1)->first();
        //});

        $registry['poll_id'] = $entry->id;

        //$items = Cache::remember('votes',$min,function() {
            //global $registry;
            $items = \App\Poll::select('id', 'title')->where('parent_id', $entry->id)->getvotes()->get();
        //});

        if(count($items) > 0){
            $registry['cookie'] = Cookie::get('vote');
            $output .= '<div class="cat-list" id="gamokitxva" style="width:550px;">';
            $output .= '<div class="rub-title-left"><a><div><h3>'.trans('all.poll').'</h3></div></a></div>';

            $output .= '<div id="poll" data-route="'.action('Admin\PollsController@vote').'" data-token="'.csrf_token().'" data-id="'.$entry->id.'">';
            $output .= '<h4>'.$entry->title.'</h4>';
            $output .= '<div class="poll">';
            $output .= '<div class="poll-list">';

            $registry['sum'] = 0;
            $registry['sum'] = ($registry['sum'] < 0) ? 0 : - count($items);

            $registry['voted'] = false;
            foreach($items as $key=>$item){
                foreach($item->votes as $k=>$vote):
                    if(!empty($registry['cookie']) && $registry['cookie'] == $vote->cookie){
                        $registry['voted'] = true;

                    };
                    $registry['sum']++;
                endforeach;
            }

            foreach($items as $item) {

                $class1 = ($registry['voted'] == false) ? 'vote-show' : 'vote-hide';
                $class2 = ($registry['voted'] == true) ? 'vote-show' : 'vote-hide';
                $output .= '<div class="poll-unv '.$class1.'"><input type="radio" id="p_'.$item->id.'" value="' . $item->id . '" name="vote"><label for="p_'.$item->id.'">' . $item->title . '</label></div>';

                $v = count($item->votes) - 1;
                $fak = ($registry['sum'] <= 0) ? 0 : round(number_format((($v / $registry['sum']) * 100),2),2);
                $output .= '<div class="poll-voted '.$class2.'">' . $item->title . ' - ' . $fak . '%</div>';

            }


                $output .= '<div class="poll-voted '.$class2.'">'.trans('all.sum').' - '.$registry['sum'].' '.trans('all.voice').'</div>';
                $output .= '</div>';
                $output .= '<div><div class="vote poll-unv '.$class1.'"><span></span><a onClick="vote(\'#poll\')">'.trans('all.vote').'</a></div></div>';

            $output .= '</div></div><div class="fb-like" data-href="'.url().'/poll/'.$entry->id.'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div>';
        }
        return $output;

    }
}


if(! function_exists('pageWidget')){
    function pageWidget($slug,$more=false,$min,$tags=array(),$title=true){
        global $registry;
        $output ='';
        $registry['slug'] = $slug;
        //Cache::pull($registry['slug']);
        $entry = Cache::remember($registry['slug'],$min,function() {
            global $registry;
            return \App\Article::select('slug', 'title','body')->where('slug',$registry['slug'])->first();
        });

        if(count($entry) > 0){
            if($title == true){
            $output .= '<div class="rub-title-gray"><a href="/'.$slug.'"><div><h3>'.$entry->title.'</h3></div></a></div>';
            }
            if(count($tags) > 0){
                $explode = explode('<!-- pagebreak -->',$entry->body);
                if(count($explode) > 0){
                foreach($tags as $key=>$i){
                    $output .= strip_tags($explode[$key]).'<br>';
                }
                }
            }else{
                $output .= $entry->body;
            }
            if($more == true){
              $output .=  ' <a href="/'.$slug.'"><b>'.trans('all.fully').'...</b></a>';
            }
        }
        return $output;
    }
}


if(! function_exists('catWidget')){
    function catWidget(){
        $output = '';
        $entry = Cache::get('rubrics');
        if(count($entry)>0){
            $output .= '<div class="rub-title-gray"><a><div><h3>'.trans('all.rubrics').'</h3></div></a></div>';
            $output .= '<ul class="footer-cat">';
            foreach($entry as $item):
                $output .= '<li><a href="/cat/'.$item->slug.'">'.$item->name.'</a></li>';
            endforeach;
            $output .= '</ul>';
        }
        return $output;
    }
}


if(! function_exists('sameWidget')){
    function sameWidget($in=array(),$current){
        global $registry;

        $output = '';
        $in = $in->toArray();
        $same = \App\Article::latest('published_at')->select('news_id','staties_id','img','slug', 'title','head','published_at')->nothis($current)->published()->orderall($in)->take(5)->get();

        if(count($same) > 0){
            $output .= '<div class="cat-list">';
            $output .='<ul>';
            foreach($same as $item):
                $url = (strpos(URL::current(),'news_id') == false) ? get_articles_url($item->staties_id,$item->slug) : get_news_url($item->news_id,$item->slug);
                if(!empty($item->img)){
                    $output .= '<li><div><a href="'.$url.'">';

                    $output .= '<img src="'.get_news_small_img($item->img).'" title="'.$item->title.'" align="left">';

                    $output .= '</a></div>';
                }
                $output .= '<div';
                if(empty($item->img)){$output .=' style="width:95%" ';} $output.='>';

                $output .= '<a href="'.$url.'">';
                $output .= '<h4>'.$item->title.'</h4>';
                $output .= '<small>'.date('H:i | d.m.Y',strtotime($item->published_at)).'</small><br>';
                $output .= '<span>'.$item->head.'</span>';
                $output .= '</a></div>';
                $output .= '</li>';
            endforeach;
            $output .= '</ul>';
            $output .= '</div>';

        }
        return $output;
    }
}


if(! function_exists('get_currency')){
    function get_currency($min=0,$options=array()){
        $out = '';
        $entry = Cache::remember('currency',$min,function(){
            return DB::table('currency')->select('name','currency')->whereIn('id',[41,14])->get();
        });

        if(count($entry) > 0){
            if(count($options) > 0){
                if(isset($options['class'])){
                    $class = 'class="'.$options['class'].'"';
                }
            }
            $out .= '<ul '.$class.'>';
            foreach($entry as $item):
                if($item->name == 'USD'){
                    $active = 'class="active"';
                }else{
                    $active = 'class="inactive"';
                }
                $out .= '<li '.$active.'><img src="/uploads/flags/'.$item->name.'.png" width="24"> '.$item->name.' 1 = <img src="/uploads/flags/GEL.png" width="24"> GEL '.$item->currency.'</li>';
            endforeach;
            $out .= '</ul>';
            return $out;
        }else{
            return false;
        }
    }
}


if(! function_exists('get_weather')){
    function get_weather($city,$dir,$lang){
        global $registry;

        $registry['city'] = $city;
        $cache = Cache::remember('weather',30,function(){
          global $registry;
            $week_days = array(1 => 'ორშაბათი',2 => 'სამშაბათი',3 => 'ოთხშაბათი',4 => 'ხუთშაბათი',5 => 'პარასკევი',6 => 'შაბათი',7 => 'კვირა');
            $weather = new weather("221dd2e63e6ac50ded13b55cb431b",$week_days);
            if(isset($weather)){
                return $weather->city_w($registry['city'],1,true);
           }
        });

        $output = '<img src="'. $dir . $cache['w_icons'][0].'" width="28"><span style="position:relative;top:4px;"> '.$cache['w_text'][0] .' - <b style="color:#004f94;">'. $lang.' '.$cache['weather']->tempC.'&deg;</b></span>';

        return $output;

    }
}


if(! function_exists('get_banner')){
    function get_banner($position,$options = array()){


        $banner = false;

        $options['class'] = (!empty($options['class'])) ? $options['class'] : 'banner-place';
        if($position > 0 or !empty($position)){
            if(is_numeric($position) > 0 and !ctype_alpha($position)){
                $banner = Banner::bannercat($position)->select('url','banner','size_x','size_y')->bannerdate()->orderBy('finished_at','desc')->first();
            }else{
                $banner = Banner::bannerposition($position)->select('url','banner','size_x','size_y')->bannerdate()->orderBy('finished_at','desc')->first();
            }

            if($banner <> null){
                $options['width'] = ($banner->size_x > 0) ? $banner->size_x.'px' : ((empty($options['width'])) ? '100%' : $options['width'].'px');
                $options['height'] = ($banner->size_y > 0) ? $banner->size_y.'px' : ((empty($options['height'])) ? '100%' : $options['height'].'px');
                $banner = '<div style="position:relative;" class="'.$options['class'].'"><a href="'.$banner->url.'" target="_blank" style="position:absolute;display:block;width:'.$options['width'].';height:'.$options['height'].';"></a><object data="'.$banner->banner.'" type="application/x-shockwave-flash" width="'.$options['width'].'" height="'.$options['height'].'"><param name="wmode" value="opaque" /></object></div>';
            }else{
                $options['width'] = ($options['width'] > 0) ? $options['width'].'px' : '100%';
                $options['height'] = ($options['height'] > 0) ? $options['height'].'px' : '100%';
                $banner = '<div style="position:relative;" class="'.$options['class'].'"><object data="'.url().'/uploads/all/Banners/default_'.$options['width'].'_x_'.$options['height'].'.png" type="application/x-shockwave-flash" width="'.$options['width'].'" height="'.$options['height'].'"><param name="wmode" value="opaque" /></object></div>';
            }
        }
        return $banner;
    }
}
?>