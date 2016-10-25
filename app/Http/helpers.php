<?php
/*
 * Created at 6/27/2015
 * Author: Salikh Gurgenidze
 * Nickname: Vati Child
 * Company: IT-Solutions
 * Website: www.it-solutions.ge
 */


use App\Setting;
use Illuminate\Support\Facades\Auth;
use App\Module;

if (! function_exists('get_role_permissions'))
{
    /**
     * @param $name
     * @return array|bool
     */
    function get_role_permissions($name,$extra = [])
    {
        if(Illuminate\Support\Facades\Auth::check()){
            $auth = Illuminate\Support\Facades\Auth::user();
            $array = unserialize($auth->roles[0]->permissions);
            if(is_array($array)){
                if(array_key_exists($name,$array)){
                    if(count($extra) > 0){
                        $array[$name] = $array[$name] + value_as_key($extra);
                    }
                    return array_keys($array[$name]);
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
}

if(!function_exists('value_as_key')){
    function value_as_key($array){
        $result = [];
        if(is_array($array) && count($array) > 0){
            foreach($array as $value){
                $result[$value] = $value;
            }
        }
        return $result;
    }
}
//if (! function_exists('get_role_permissions'))
//{
//    function get_role_permissions($auth,$name)
//    {
//        $array = unserialize($auth->roles[0]->permissions);
//        if(is_array($array)){
//            if(array_key_exists($name,$array)){
//                return array_keys($array[$name]);
//            }else{
//                return false;
//            }
//        }
//    }
//}

if (! function_exists('guest_role_permissions'))
{
    function guest_role_permissions($name)
    {
        $role = \App\Role::where('name','guest')->get();
        $array = unserialize($role[0]->permissions);
        if(array_key_exists($name,$array)){
            return array_keys($array[$name]);
        }else{
            return false;
        }

    }
}

if(! function_exists('get_trans')){
    function get_trans($name){
        if(Lang::has('all.'.$name)){
            return trans('all.'.$name);
        }else{
            return $name;
        }
    }
}

if (! function_exists('parseAndPrintTree'))
{
    function parseAndPrintTree($tree, $root=0,$i=0)
    {

        $line = ($i == 0) ? '' : '-';
        for($a=0;$a<$i;$a++){
            $line .= $line;
        }
        $i++;
        if(!is_null($tree) && count($tree) > 0) {

            foreach($tree as $child => $parent) {
                if($parent->parent == $root) {
                    unset($tree[$child]);
                    echo '<tr> <td>'.$parent->id.'</td> <td><a href="'.action("Admin\\FieldsController@show",$parent->id).'">'.$line.' '.get_trans($parent->name).'</a></td> <td>'.$parent->slug.'</td><td>';

                    if($root > 0){
                        echo '<input type="number" value="'.$parent->sort.'" min="-128" max="127" data-url="'.action('Admin\CategoriesController@sort',$parent->id).'" data-token="'.csrf_token().'" style="width:60px;">';
                    }
                    echo '</td><td>';
                    if($root > 0 or Auth::user()->hasRole('Super Admin')):
                        echo'<a href="'.action('Admin\CategoriesController@edit',$parent->id).'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                         <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="'.action('Admin\CategoriesController@destroy',$parent->id).'" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                    endif;
                    echo '</td>';
                        parseAndPrintTree($tree, $parent->id,$i);
                    echo '</tr>';

                }

            }

        }
    }
}



if(! function_exists('filter_cookies'))
{
    function filter_cookies($request,$prefix){
        if(count($request->input()) > 0){
            foreach($request->input() as $key => $input){
                if($request->input($prefix.'filter') == 0){
                    $request->session()->forget($key);
                }else{
                    session([$key=>$input]);
                }

            }
        }
    }
}

if(! function_exists('filter_request'))
{
    function filter_request($request,$value,$def=null){
        if($request->input($value) <> '' or $request->input($value) > 0){
            return $request->input($value);
        }else if($request->session()->has($value)){
            return session($value);
        }else{
            return $def;
        }
    }
}


if(! function_exists('array_name')){
    function array_name($array = array()){
        foreach($array as $key=>$a){
            unset($array[$key]);
            $array[$a] = $a;
        }
        return $array;
    }
}

if(! function_exists('array_name_key')){
    function array_name_key($array = array()){
        foreach($array as $key=>$a){
            $array[$key] = $a;
        }
        return $array;
    }
}

if(! function_exists('array_id_name')){
    function array_id_name($array = array()){
        foreach($array as $key=>$a){
            unset($array[$key]);
            $array[$a->id] = $a->name;
        }
        return $array;
    }
}

if(! function_exists('array_id')){
    function array_id($array = array()){
        $i=0;foreach($array as $key=>$a){ $i++;
            unset($array[$key]);
            $array[] = $a->id;
        }
        return $array;
    }
}

if(! function_exists('array_two_field')){
    function array_two_field($array = array()){
        $new_array = array();
        $result = array(''=>'---');
        $i=0; foreach($array as $key=>$item):
            $new_array[$i] = $item;
            $i++;
        endforeach;
        for($i=0;$i<count($new_array[0]);$i++){
            $result[$new_array[1][$i]] = trans('ex.'.$new_array[0][$i]);
        }
        return $result;
    }

}





if(! function_exists('get_news_img')){
    function get_news_img($url){
        if(strpos($url,'/') == false){
          // return url().'/uploads/all/news/'.$url;
            return url().'/images/large_news_img/'.$url;
        }else{
            return $url;
        }
    }
}

if(! function_exists('get_news_small_img')){
    function get_news_small_img($url){
        if(strpos($url,'/') == false){
            // return url().'/uploads/all/news/'.$url;
            return url().'/images/small_news_img/'.$url;
        }else{
            return $url;
        }
    }
}

if(! function_exists('get_gallery_img')){
    function get_gallery_img($url){
        if(strpos($url,'/') == false){
            return url().'/images/large_photoreport/'.$url;
        }else{
            return $url;
        }
    }
}

if(! function_exists('get_gallery_small_img')){
    function get_gallery_small_img($url){
        if(strpos($url,'/') == false){
            return url().'/images/large_photoreport/'.$url;
        }else{
            return $url;
        }
    }
}



if(! function_exists('get_articles_url')){
    function get_articles_url($id,$slug = ''){
        return (empty($slug)) ? url().$id : url().$slug;
    }
}

if(! function_exists('get_images_url')){
    function get_images_url($id,$slug = ''){
        return (empty($slug)) ? '/gallery/'.$id : '/gallery/'.$slug;
    }
}

if(! function_exists('get_image_from_array')){
    function get_image_from_array($item,$num = 0){
        $item = unserialize($item);
        return $item[$num];
    }
}

if(! function_exists('social_meta_data')){
    function social_meta_data($data,$type){
        $out = false;
        if(isset($data->id) > 0){
            if($type == 1){
                $url = get_articles_url($data->staties_id,$data->slug);
                $image = get_news_img($data->img);
                $desc = (!empty($data->meta_desc)) ? $data->meta_desc : $data->head;
            }else{
                $url = url().get_images_url($data->id,$data->slug);
                $image = unserialize($data->images);
                $image = get_gallery_img($image[0]);
                $desc = (!empty($data->meta_desc)) ? $data->meta_desc : substr($data->body,0,100);
            }
            $out .= '<meta name="description" lang="ge" content="'.$data->meta_desc.'" />';
            $out .='<meta name="keywords" lang="ge" content="'.$data->meta_key.'" />';
            $out .='<title>'.$data->title.'</title>';
            $out .= '<meta property="og:title" content="'.str_replace('"','&quot;',$data->title).'" />';
            $out .= '<meta property="og:type" content="website" />';
            $out .= '<meta property="og:url" content="'.$url.'" />';
            $out .= '<meta property="og:image" content="'.$image.'" />';
            $out .= '<meta property="og:site_name" content=""/>';
            $out .= '<meta property="og:description" content="'.$desc.'"/>';
        }
        return $out;
    }
}



if(! function_exists('get_modules')){
    function get_modules(){
        $module_list = Module::where('status',1)->orderBy('sort','asc')->get();
        return $module_list;
    }
}

if(! function_exists('get_module_names')){
    function get_module_names($except = array()){
        if(count(get_modules()) > 0){
            $module_names_array = array();
            $module_names = get_modules();
            foreach($module_names as $item):
                if(!in_array($item->name,$except)){
                    $module_names_array[] = $item->name;
                }
            endforeach;
        return $module_names_array;
        }else{
            return false;
        }
    }
}


if(! function_exists('hasFields')){
    function hasFields($args = array(),$options=array(),$extra_fields = false){


        $fields = App\Field::select('id','cat_id','value','trans','tag','type')->whereIn('cat_id',$args)->get();
        $output = '';

       $edit_values = ($extra_fields != false) ? $extra_fields : '';


        if(count($fields) > 0){
            foreach($fields as $field){
                if(count($options) > 0){
                    if($options[$field->tag]['col-sm']){
                        $col_sm = 'col-sm-'.$options[$field->tag]['col-sm'];
                    }else{
                        $col_sm = 'col-sm-4';
                    }
                }
                $output .= '<div class="row"><div class="'.$col_sm.'"><div class="form-group">';
                $output .= Form::label('extra_fields['.$field->trans.']',trans('ex.'.$field->trans));

                $values = unserialize($field->value);
                $val = (!empty($edit_values)) ? ((!isset($edit_values[$field->trans])) ? '' : $edit_values[$field->trans]) : '';

                switch($field->tag):
                    case 'textarea' :
                        $output .= Form::textarea('extra_fields['.$field->trans.']',$val,['class'=>'form-control']);
                        break;
                    case 'select' :
                        if(count($values) > 0):
                           $output .= Form::select('extra_fields['.$field->trans.']',array_two_field($values),$val,['class'=>'form-control top0']);
                        endif;
                        break;
                    default:
                        switch($field->type):
                            case 'checkbox':
                                $output .= '<div class="check-boxes">';
                                if(count($values) > 0):
                                    for($i=0;$i<count($values['trans']);$i++):
                                        $v = (isset($val[$values['trans'][$i]]) && $val[$values['trans'][$i]] == $values['val'][$i]) ? 1 : null;
                                        $output .= '<label class="checkbox-inline">'.Form::checkbox('extra_fields['.$field->trans.']['.$values['trans'][$i].']',$values['val'][$i],$v).' '.trans('ex.'.$values['trans'][$i]).'</label> ';
                                    endfor;
                                endif;
                                $output .= '</div>';
                                break;
                            case 'radio':
                                $output .= '<div class="radio-buttons">';
                                if(count($values) > 0):
                                    for($i=0;$i<count($values['trans']);$i++):
                                        $v = ($val == $values['val'][$i]) ? 1 : null;
                                        $output .= '<label class="checkbox-inline">'.Form::radio('extra_fields['.$field->trans.']',$values['val'][$i],$v).' '.trans('ex.'.$values['trans'][$i]).'</label> ';
                                    endfor;
                                endif;
                                $output .= '</div>';
                                break;
                            default:

                                $output .= Form::text('extra_fields['.$field->trans.']',$val,['class'=>'form-control']);
                                break;
                        endswitch;
                        break;
                endswitch;
                $output .= '</div></div></div>';
            }
        }
        return $output;
    }
}

if(!function_exists('get_template_name')){
    function get_template_name(){
        echo $_SERVER['DOCUMENT_ROOT'];
    }
}

if(!function_exists('get_setting')){
    function get_setting($name){
        $value = false;
        $setting = Cache::rememberForever('settings_'.\App::getLocale(),function() {
            return Setting::select('value','name')->where('lang',\App::getLocale())->get();
        });
        if($setting){
            foreach($setting as $item){
               if($item->name == $name){
                   $value = $item->value;
               }
            }
            return $value;
        }else{
            return false;
        }
    }
}


if(!function_exists('get_title')){
    function get_title(){
        if(Config::get('registry.title')){
            return Config::get('registry.title');
        }else{
            return get_setting('site_title');
        }
    }
}

if(!function_exists('get_meta')){
    function get_meta($ajax = false){
        $output = '';
        if($ajax == true){$output .= '<title>'.Config::get('registry.title').'</title>';}
        $output .= '<meta content="'.Config::get('registry.section').'" name="section">';
        $output .= '<meta content="'.Config::get('registry.pubdate').'" property="og:pubdate"><meta content="'.Config::get('registry.pubdate').'" name="pubdate">';
        $output .= '<meta content="'.Config::get('registry.lastmod').'" name="lastmod">';
        $output .= '<meta content="'.Request::url().'" property="og:url">';
        $output .= '<meta content="'.Config::get('registry.author').'" name="author">';
        $output .= '<meta content="'.Config::get('registry.social_title').'" property="og:title">';
        $output .='<meta content="'.check_value(Config::get('registry.keywords'),get_setting('site_tags')).'" name="keywords">';
        $output .= '<meta content="'.Config::get('registry.type').'" property="og:type">';
        $output .='<meta content="'.Config::get('registry.site_name').'" property="og:site_name">';
        $output .='<meta content="'.Config::get('registry.image').'" property="og:image"><meta content="'.Config::get('registry.image').'" name="thumbnail">' ;
        $output .= '<meta content="'.check_value(Config::get('registry.description'),get_setting('site_description')).'" property="og:description"><meta content="'.check_value(Config::get('registry.description'),get_setting('site_description')).'" name="description">';
        $output .=(Config::get('registry.app_id') <> '') ? '<meta content="'.Config::get('registry.app_id').'" property="fb:app_id">' : '' ;

        return $output;
    }
}

if(!function_exists('set_globals')){
    function set_globals($items=[]){
        if(count($items) > 0){
            foreach($items as $k=>$value){
                Config::set('registry.'.$k,$value);
            }
        }
    }
}

if(!function_exists('check_value')){
    function check_value($first,$second){
        if(empty($first)){
            return $second;
        }else{
            return $first;
        }
    }
}

if(!function_exists('get_cats')){
    function get_cats(){
        $cats = Cache::rememberForever('cats',function() {
            return App\Cat::select('id','name','parent','slug')->latest()->get();
        });
        return $cats;
    }
}



if(!function_exists('get_cat_by_parent')){
    function get_cat_by_parent($id){
        $cats = array();
        if(count(get_cats()) > 0){
            $i=0;foreach(get_cats() as $item):
                if(is_array($id)){
                    if(in_array($item->parent,$id)){
                        $cats[$i]['id'] = $item->id;
                        $cats[$i]['parent'] = $item->parent;
                        $cats[$i]['name'] = $item->name;
                        $cats[$i]['slug'] = $item->slug;
                    }
                }else{
                    if($item->parent == $id){
                        $cats[$i]['id'] = $item->id;
                        $cats[$i]['parent'] = $item->parent;
                        $cats[$i]['name'] = $item->name;
                        $cats[$i]['slug'] = $item->slug;
                    }
                }

            $i++;
            endforeach;
        }
        return $cats;
    }
}

if(!function_exists('get_cat_by_parents')){
    function get_cat_by_parents($array = array()){
        $cats = array();
        if(count(get_cats()) > 0){
            $i=0;foreach(get_cats() as $item):
                if(in_array($item->parent,$array)){
                    $cats[$i]['id'] = $item->id;
                    $cats[$i]['parent'] = $item->parent;
                    $cats[$i]['name'] = $item->name;
                }
                $i++;
            endforeach;
        }
        return $cats;
    }
}

function badeStartDate($date){
    return date('Y-m-d',$date).'T'.date('H:i:s',$date).'+00:00';
}
function badeEndDate($date){
    $t = date('H:i',$date);
    $t = strtotime($t) + 60 * 60;
    return date('Y-m-d',$date).'T'.date('H:i:s',$t).'+00:00';
}

if(!function_exists('get_pages')){
    function get_pages($num,$cat = 1){
        global $registry;
        $pg = array();
        if(!is_array($num)){
            $registry['cat'] = $num;
        }else{
            $registry['cat'] = $cat;
        }

        $pages = Cache::rememberForever('pages_'.$registry['cat'].'_'.\App::getLocale() ,function(){
            global $registry;
            return App\Article::select('id','slug','title','body')->where('lang',\App::getLocale())->getone($registry['cat'])->published()->get();
        });
        if(is_array($num) && count($num) > 0){
            foreach($pages as $page){
                if(in_array($page->id,$num)){
                    $pg[] = $page;
                }
            }
            return $pg;
        }else{
            return $pages;
        }
    }
}

if(!function_exists('get_nav_menu')){
    function get_nav_menu($lists = array(),$args=array()){
        $out = '';

        if(count($lists) > 0){
            $out .= '<ul class="'.get_arg('class',$args).'">';
            if(get_arg('home',$args)){
                $active = (!Route::getCurrentRoute()->id) ? 'class="active"' : '';
                $out .= '<li '.$active.'>
                              <a href="'.get_arg('home',$args).'" >
                                '.trans('all.home').'
                              </a>
                        </li>';
            }
            $i=0;foreach($lists as $list){$i++;
               $title = (get_arg('title',$args)) ? get_arg('title',$args) : 'title';
               $active = (Route::getCurrentRoute()->id == $list->slug) ? 'class="active"' : '';
               $out .= '<li '.$active.'>
                              <a class="'.get_arg('a.class'.$i,$args).'" href="'.action(get_arg('route',$args),$list->slug).'" >
                                '.$list->$title.'
                              </a>
                        </li>';
            }
            $out .= '</ul>';
            return $out;
        }else{
           return false;
        }
    }
}

if(!function_exists('get_argument')){
    function get_arg($key,$array=array()){
         if(array_key_exists($key,$array)){
             return $array[$key];
         }else{
             return false;
         }
    }
}

if(!function_exists('do_shortcode')){
    function do_shortcode($content) {
          if(false !== strpos($content,'[')){
              preg_match_all("/\[[^\]]*\]/", $content, $matches);
              if(count($matches) > 0){

                  foreach($matches as $match){
                      if(count($match) > 0){
                          foreach($match as $m){
                              $r1 = str_replace('[','',$m);
                              $r2 = str_replace(']','',$r1);
                              $r3 = explode('.',$r2);
                              $r4 = $r3[count($r3) - 1];
                              if(file_exists('theme/pages/shortcode/'.$r4.'.blade.php')){
                                  $placed = view($r2);
                                  $content = str_replace($m,$placed,$content);
                              }

                          }
                          return html_entity_decode($content);
                      }
                  }
              }

          }
        return html_entity_decode($content);
    }
}

if(!function_exists('filter_title')){
    function filter_title($string) {
        $array_string = str_split($string);
        if( $array_string[0] == '*'){
            return false;
        }else{
            return $string;
        }
    }
}


if(!function_exists('get_languages')){
    function get_languages(){
        return [
            'en'=>'English',
            'fi'=>'Suomi'
        ];
    }
}

if(!function_exists('get_img_url')){
    function get_img_url($img = ''){
        if(!empty($img) or $img <> null or $img <> 0){
            if(strpos($img,'http://') === false){
                $url=@getimagesize('http://radioclassic.fi/sites/default/files/styles/competition_500x80/public/'.$img.'');
                if($url != false)
                {
                    $out = 'http://radioclassic.fi/sites/default/files/styles/competition_500x80/public/'.$img;
                    //$out = 'http://radioclassic.fi/sites/default/files/'.$img;
                }
                else
                {
                    $out = 'http://radioclassic.fi/sites/default/files/styles/reviews_352x352/public/'.$img.'?itok='.uniqid();
                }

            }else{
                $out = $img;
            }
            return $out;
        }else{
            return false;
        }
    }
}



if(!function_exists('add_image_array')){
    function add_image_array($data = array()){
        $image_gallery = array();
        if(count($data) > 0){
            $i=0;foreach($data as $img){
                $image_gallery[$i]['img'] = $img['img'];
                $image_gallery[$i]['title'] = $img['title'];
                $image_gallery[$i]['alt'] = $img['alt'];
                $image_gallery[$i]['source'] = $img['source'];
                $image_gallery[$i]['author'] = $img['author'];
                $image_gallery[$i]['status'] = $img['status'];
                $image_gallery[$i]['meta_desc'] = $img['meta_desc'];
                $image_gallery[$i]['meta_key'] = $img['meta_key'];
                $i++;
            }
        }
        return $image_gallery;
    }
}

if(!function_exists('validate_extra_field')){
    function validate_extra_field($item,$name){
        if(isset($item[$name])){
            return $item[$name];
        }
    }
}

if(!function_exists('validate_extra_fields')){
    function validate_extra_fields($item,$array=array()){
        $output = '';
        for($i=0;$i<count($array);$i++){
             if(isset($item[$array[$i]])){
                 unset($array[$i]);
                 $output = validate_extra_fields($item[$array[$i]],$array);
             }
        }
        return $output;
    }
}

function mysql_escape_no_conn( $input )
{
    if (is_array($input)) {
        return array_map(__METHOD__, $input);
    }
    if (!empty($input) && is_string($input)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
            array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),
            $input);
    }

    return $input;
}

if(!function_exists('stripslashes_deep')){
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
            array_map('stripslashes_deep', $value) :
            stripslashes($value);

        return $value;
    }
}

function checkXmlField($element,$name){
    if(isset($element->$name)){
       $new_element = array((string) $element->$name)[0];
        if(!empty($new_element)){
            return $new_element;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

/**
 * @return mixed
 */
function getCompetitions(){
   $competitions = App\Article::select('id','title','slug','extra_fields','published_at','img')->where('lang',App::getLocale())->orderBy('published_at','desc')->finished()->getone(76)->get();
   return $competitions;
}

function youtube($links=array()){
    $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=".join(',',$links)."&key=AIzaSyCjx4J5RH3TcE-KQCSwjyC2LX_j6pTOn2I";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    return $response_a;
}

function youtube_url($youtube){
    $youtube = parse_url($youtube);
    if(isset($youtube['query'])){
        $explode = explode('=',$youtube['query']);
        if(!empty($explode[1])){
            return $explode[1];
        }
    }elseif(isset($youtube['path']) && !isset($youtube['query'])){
        if(!empty($youtube['path'])){
            return str_replace('/','',$youtube['path']);
        }
    }else{
        return false;
    }
}


function get_youtube_array($items){
    $links = '';
    if(count($items) > 0){
        $links = array_pluck($items,'extra_fields');
        $array = [];
        if(count($links) > 0){
            for($i=0;$i<count($links);$i++){
                $array[] = unserialize($links[$i]);
            }
            if(count($array) > 0){
                $links = array_map('youtube_url',array_pluck($array,'youtube'));
            }
        }
    }
    return $links;
}

function youtubeVideo($item,$desc = false){
    $output = '';
    if(validate_extra_field(unserialize($item->extra_fields),'youtube')):
        $you = youtube([youtube_url(validate_extra_field(unserialize($item->extra_fields),'youtube'))]);
        $output .= '<iframe width="560" style="float:left;margin:0 20px 20px 0;" height="315" src="https://www.youtube.com/embed/'.youtube_url(validate_extra_field(unserialize($item->extra_fields),'youtube')).'" frameborder="0" allowfullscreen></iframe>';
        /*if($desc == true):
            $output .= $you->items[0]->snippet->localized->description;
        endif;*/
    endif;
    return $output;
}


function facebookGallery($key,$secret,$limit=''){
    if($galleryJson = @file_get_contents('https://graph.facebook.com/397458577017091?fields=photos'.$limit.'&access_token='.$key.'|'.$secret)){
        return json_decode($galleryJson);
    }else{
        return false;
    }
}

function radioPlaylist(){
    $playlist = DB::table('radio_playlist')->select('tid','img','timestamp','data','download')->orderBy('timestamp','desc')->where('timestamp','LIKE','%'.date('Y-m-d').'%')->get();
    if($playlist){
        return $playlist;
    }
}

function radioPlaylistImage($search=''){
        $url = "https://itunes.apple.com/search?limit=1&term=".filterItunes(str_limit($search,60));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        return (count(get_object_vars($response_a))  > 0) ? get_object_vars($response_a) : false;
}

function filterItunes($search=''){
    $search = str_replace(' ','+',$search);
    $search = str_replace(':','+',$search);
    $search = str_replace(';','+',$search);
    $search = str_replace("'",'+',$search);
    $search = str_replace('"','+',$search);
    $search = str_replace('(','+',$search);
    $search = str_replace(')','+',$search);
    $search = str_replace(',','+',$search);
    return $search;
}

function updateRadioImage($id,$img,$download){
    //dump(['id'=>$id,'img'=>$img,'download'=>$download]);
    DB::table('radio_playlist')->where('tid',$id)->update(['img'=>$img,'download'=>$download]);
}

function menu_builder_articles(){
    $articles = App\Article::select('title','slug')->where('menu_builder',1)->get();
    return $articles;
}


function get_slider_items(){
    $slider = Cache::rememberForever('slider_'.App::getLocale(),function(){
        return App\Slider::select('poster')->where('is_publish',1)->get()->toArray();
    });

    return json_encode(array_pluck($slider,'poster'),JSON_UNESCAPED_UNICODE);
}

if(! function_exists('NameAsKey')){
    function NameAsKey($array,$name = 'name'){
        $result = [];
        if(count($array) > 0){
            foreach($array as $key=>$item){
                $result[$item->$name] = $item->$name;
            }
        }
        return $result;
    }
}

if(!function_exists('get_value_by_name')){
    function get_value_by_name($object,$name){
        if(count($object) > 0){
            foreach($object as $key=>$item){
                if($item->name == $name){
                    return $item->value;
                }
            }
        }
    }
}

if(!function_exists('get_youtube')){
    function get_youtube($string){
        preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $string, $matches);
        if(isset($matches) && count($matches) > 0){
            if(strpos($matches[1],'youtube.com')){
                $result = str_replace("560","100%",$matches[0]);
                $result = str_replace("315","250",$result);
                return $result;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}

if(!function_exists('permitSortNews')){
    function permitSortNews()
    {
        return (Route::getCurrentRoute()->uri() == 'is-admin/articles/sort-news') ? true : false;
    }
}

if(!function_exists('sortByPos')){
    function sortByPos($news)
    {
        $sorted = [];
        
        for($i = 0, $j = -(count($news)); $i < count($news); $i++, $j++)
        {
            if($news[$i]->pos != null)
            {
                if(!array_key_exists($news[$i]->pos, $sorted))
                {
                    $sorted[$news[$i]->pos] = $news[$i];
    
                }else{
                    $sorted[$j] = $news[$i];
                }
    
            } else{
                $sorted[$j] = $news[$i];
           }
        }
        
        ksort($sorted);
    
        return (object)$sorted;
    }
}

?>