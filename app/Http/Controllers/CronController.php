<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Reader;
class CronController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function playlistImages()
    {
        $playlist = DB::table('radio_playlist')->select('tid','img','timestamp','data')->where('download','')->orderBy('timestamp','desc')->take(10)->get();
        $i=0;
        $item['results'] = [];
        if(count($playlist) > 0){
            foreach($playlist as $play){
                $data = unserialize($play->data);

                if(count($data) > 0){
                    if(count($item['results']) <= 0) {
                        if (validate_extra_field($data, 'soloist')) {
                            $item = radioPlaylistImage(validate_extra_field($data, 'soloist') . ' ' . validate_extra_field($data, 'title'));
                        }
                    }

                    if(count($item['results']) <= 0){
                        if(validate_extra_field($data,'album')){
                            $item = radioPlaylistImage(validate_extra_field($data, 'album') . ' ' . validate_extra_field($data, 'title'));
                        }
                    }

                    if(count($item['results']) <= 0){
                        if(validate_extra_field($data,'performer')){
                            $item = radioPlaylistImage(validate_extra_field($data,'performer').' '.validate_extra_field($data,'title'));
                        }
                    }

                    if(count($item['results']) <= 0){
                        if(validate_extra_field($data,'composer')){
                            $item = radioPlaylistImage(validate_extra_field($data, 'composer') . ' ' . validate_extra_field($data, 'title'));
                        }
                    }

                    if(count($item['results']) > 0){
                        $id = $play->tid;
                        $image = $item['results'][0]->artworkUrl100;
                        $download = $item['results'][0]->trackViewUrl.'&at=1010l11860';
                        //$title = $item['results'][0]->title;
                    }else{
                        $id = $play->tid;
                        $image = 'theme/images/no_photo.png';
                        $download = 'null';
                        //$title = 'no';
                    }
                    updateRadioImage($id,$image,$download);
                    $item['results'] = [];
                }
                //echo $i.'<br>';
                //dump($item);
                $i++;
            }
        }
        echo 1;
        //dump($playlist);
    }




    /**
     * get Playlist
     * @return mixed
     */
    public function getPlaylistXml(){
        $app      = new Container();
        $document = new Document($app);
        $stub     = new Reader($document);
        $xml   = $stub->load('http://10.10.86.234/DJProAPI/web/views/OnairPlaylistDetailed.php?OUTPUTMETHOD=xml');
        $data = array();
        $now = array();
        $next = array();
        if($xml){
            if(checkXmlField($xml->getContent()->element[0],'Artist') && checkXmlField($xml->getContent()->element[0],'Title')){
                $time = time() - (360 * 5);
                $check = DB::table('radio_playlist')->select('tid')->where('data','LIKE','%'.checkXmlField($xml->getContent()->element[0],'Code').'"%')->where('timestamp','>',date('Y-m-d H:i:s',$time))->orderBy('timestamp','desc')->first();

                if($check == false){
                    $data['code'] = checkXmlField($xml->getContent()->element[0],'Code');
                    $data['title'] = checkXmlField($xml->getContent()->element[0],'Title');
                    $data['local_name'] = checkXmlField($xml->getContent()->element[0],'Field_1');
                    $data['album'] = checkXmlField($xml->getContent()->element[0],'Album');
                    $data['label'] = checkXmlField($xml->getContent()->element[0],'Label');
                    $data['recordno'] = checkXmlField($xml->getContent()->element[0],'Field_2');
                    $data['performer'] = checkXmlField($xml->getContent()->element[0],'Field_7');
                    $data['soloist'] = checkXmlField($xml->getContent()->element[0],'Field_3');
                    $data['soloist2'] = checkXmlField($xml->getContent()->element[0],'Field_4');
                    $data['soloist3'] = checkXmlField($xml->getContent()->element[0],'Field_5');
                    $data['soloist4'] = checkXmlField($xml->getContent()->element[0],'Field_6');
                    $data['composer'] = checkXmlField($xml->getContent()->element[0],'Artist');
                    $data['maestro'] = checkXmlField($xml->getContent()->element[0],'Field_9');
                    DB::table('radio_playlist')->insert(['timestamp'=>Carbon::now(),'data'=>serialize($data)]);
                }
                $previous = DB::table('radio_playlist')->select('data')->orderBy('timestamp','desc')->take(1)->skip(1)->first();
                $now['title'] = checkXmlField($xml->getContent()->element[0],'Title');
                $now['composer'] = checkXmlField($xml->getContent()->element[0],'Artist');
            }else{
                $data = DB::table('radio_playlist')->select('data')->orderBy('timestamp','desc')->take(2)->get();
                $previous = $data[0];
                $now_data = unserialize($data[1]->data);
                $now['title'] = $now_data['title'];
                $now['composer'] = $now_data['composer'];
            }

            if(checkXmlField($xml->getContent()->element[1],'Artist') && checkXmlField($xml->getContent()->element[1],'Title')){
                $next['title'] = checkXmlField($xml->getContent()->element[1],'Title');
                $next['composer'] = checkXmlField($xml->getContent()->element[1],'Artist');
            }elseif(checkXmlField($xml->getContent()->element[2],'Artist') && checkXmlField($xml->getContent()->element[2],'Title')){
                $next['title'] = checkXmlField($xml->/**/getContent()->element[2],'Title');
                $next['composer'] = checkXmlField($xml->getContent()->element[2],'Artist');
            }else{
                $next['title'] = checkXmlField($xml->getContent()->element[3],'Title');
                $next['composer'] = checkXmlField($xml->getContent()->element[3],'Artist');
            }

            if($previous){
                $pre = unserialize($previous->data);
            }else{
                $pre = '';
            }
            $this->registry['previous'] = $pre;
            $this->registry['now'] = $now;
            $this->registry['next'] = $next;

            Cache::forget('currentPlaylist');
            $response = Cache::rememberForever('currentPlaylist',function(){
                return ['previous'=>$this->registry['previous'],'now'=>$this->registry['now'],'next'=>$this->registry['next']];
            });
            //return $response;
        }

    }


}
