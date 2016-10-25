@extends('theme.app')

@section('content')
    <div id="alert-messages">@include('flash::message')</div>
    <div class="container-fluid no-padding">
        <div class="read read-wrapper">
            <h3>{{$item->title}}</h3>
            <div class="read_content">
                @if(in_array(77,array_pluck($item->categories,'id')))
                    {!! youtubeVideo($item,true) !!}
                @else
                    @if(strpos($item->body,"[video:") === false && !empty($item->body))
                        @if(youtubeVideo($item,false) <> "")
                            {!! youtubeVideo($item,false) !!}
                            {!! do_shortcode($item->body) !!}
                        @else
                            @if(count($images) > 0)<div class="main-img"><img class="img-responsive" src="{!!  get_img_url($images[0]->img)!!}" /></div> @endif
                            {!! do_shortcode($item->body) !!}
                        @endif
                    @endif
                @endif
                <div class="fix"></div>
            </div>
            <div class="fix"></div>
            <div class="share-buttons">
                <ul>
                    <li><span>{{trans('all.share')}}</span></li>
                    <li class="facebook-icon-o"><a href="http://www.facebook.com/sharer.php?u={{Request::url()}}" onClick="return shareWindow('Facebook',this)"></a></li>
                    <li class="twitter-icon-o"><a href="https://twitter.com/intent/tweet?url={{Request::url()}}&amp;text={{$item->title}}&amp;via=radioclassic.fi" onClick="return shareWindow('Twitter',this)"></a></li>
                    <li class="google-icon-o"><a href="https://plus.google.com/share?url={{Request::url()}}" onClick="return shareWindow('Google',this)"></a></li>
                </ul>
            </div>
            <div class="fix"></div>
            <div class="records">
                @if(count($items) > 0)
                    <?php $y = youtube(get_youtube_array($items)); $i=0;?>
                    <div class="records-list">
                        <div class="records-title">
                            <a href="#"><span>{{trans('all.similar')}}</span></a>
                        </div>

                        <div class="records-content">
                            <ul>
                                {{--@foreach($items as $item)
                                    <li>
                                        <div class="item-img">
                                            --}}{{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : ((!empty($y->items[$i]->snippet->thumbnails->high->url)) ? $y->items[$i]->snippet->thumbnails->high->url : asset('theme/images/no_photo.png'))}}" />--}}{{--
                                            <div style="background-image: url({{(!empty($item->img)) ? get_img_url($item->img) : ((!empty($y->items[$i]->snippet->thumbnails->high->url)) ? $y->items[$i]->snippet->thumbnails->high->url : asset('theme/images/no_photo.png'))}});
                                                    background-size: cover; background-position: center center; width: 100%; height: 100%; background-repeat: no-repeat"></div>
                                            <div class="item-bg"></div>
                                        </div>
                                        <div class="item-info">
                                            <div class="item-date"> {{(!empty($item->title)) ? $item->title : $y->items[0]->snippet->localized->title}}</div>
                                            <div class="item-title">
                                                {{trans('months.'.date('n',strtotime($item->published_at))) .' '. date('d, Y',strtotime($item->published_at))}}
                                            </div>
                                            @if(count(unserialize($item->extra_fields)) > 0)
                                                @if(!empty(unserialize($item->extra_fields)['event_location']))
                                                    <div class="item-location">
                                                        {{unserialize($item->extra_fields)['event_location']}}, {{trans('all.finland')}}
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="item-more">
                                            <a href="javascript:void('')" onClick="ajaxRoute('{{action('WelcomeController@ajaxShow',[$item->categories[0]->slug,((!empty($item->slug)) ? $item->slug : $item->id)])}}','/{{$item->categories[0]->slug}}/{{((!empty($item->slug)) ? $item->slug : $item->id)}}')"><span>{{trans('all.read_more')}}</span></a>
                                        </div>
                                    </li>
                                    --}}{{--*/ $i++ /*--}}{{--
                                    @endforeach--}}
                                <li class="item-list">

                                </li>
                                <li class="item-list">

                                </li>
                                @for($i = 0; $i <= 2; $i++)

                                    <li class="item-list">
                                        <a href="{{url('/'.$items[$i]->categories[0]->slug.'/'.((!empty($items[$i]->slug)) ? $items[$i]->slug : $items[$i]->id))}}" onClick="return ajaxRoute($(this).attr('href'))">
                                            <div class="item-details">
                                                <div class="item-title">
                                                    {{check_value($items[$i]->frontpage_title,$items[$i]->title)}}
                                                </div>
                                                <div class="item-desc">
                                                    {{check_value($items[$i]->head,str_limit(preg_replace('#\<(.*?)\>#','', strip_tags($items[$i]->body)), $limit = 150, $end = '...' ))}}
                                                </div>
                                            </div>
                                            <div class="item-img">
                                                {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" />--}}
                                                <img src="{{(!empty($items[$i]->img)) ? get_img_url($items[$i]->img) : asset('theme/images/no_photo.png')}}" height="250px"/>
                                            </div>
                                        </a>
                                    </li>

                                    <?php $i++;?>
                                    @endfor
                            <!-- END NEWS 1 -->
                            </ul>
                            <div class="fix"></div>
                            <div id="preloader"></div>
                        </div>

                        <div class="item-show-more"><a onClick="loadRecords(this)" data-preloader="{{asset('theme/images/loading.GIF')}}" data-cat="{{($items[0]->categories[0]->name == 'free_event' or $items[0]->categories[0]->name == 'premium_event') ? 'events' : $items[0]->categories[0]->name}}" data-id="{{$item->id}}" data-num="2" data-token="{{csrf_token()}}" data-url="{{action('WelcomeController@loadRecords')}}">{{trans('all.show_more')}}</a></div>

                    </div>
                @endif
            </div>
            <div class="fix"></div>
        </div>
    </div>
@stop