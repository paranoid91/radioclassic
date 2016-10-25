@extends('theme.app')

@section('content')
    <div class="records">
        @if(count($items) > 0)
         <?php $y = youtube(get_youtube_array($items)); $i=0; ?>
        <div class="records-list">
            @if(count($items[0]->categories) > 0)
                @if(!empty($items[0]->categories[0]->name))
                <div class="records-title">
                    <a href="javascript:void('')">{!! ($items[0]->categories[0]->name == 'free_event' or $items[0]->categories[0]->name == 'premium_event') ? trans('all.f_events') : trans('all.f_'.$items[0]->categories[0]->name) !!}</a>
                </div>
                @endif
            @endif
            <div class="records-content">
                <ul>
                    @foreach($items as $yt)
                        <li class="item-list">
                        @if($items[0]->categories[0]->name == "youtube" || (isset($youtube_video) and $youtube_video == true) )
                        <div class="item-img">

                        </div>
                        <div>
                            <div class="data-wrap">
                                @if(in_array(77,array_pluck($yt->categories,'id')))
                                    {!! youtubeVideo($yt,true) !!}
                                @else
                                    @if(strpos($yt->body,"[video:") === false && !empty($yt->body))
                                        @if(youtubeVideo($yt,false) <> "")
                                            {!! youtubeVideo($yt,false) !!}
                                            {!! do_shortcode($yt->body) !!}
                                        @else
                                            @if(count($images) > 0)<div class="main-img"><img class="img-responsive" src="{!!  get_img_url($images[0]->img)!!}" /></div> @endif
                                            {!! do_shortcode($yt->body) !!}
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        @else
                                @if(get_youtube($yt->body))
                                    {!! get_youtube($yt->body) !!}
                                @else
                                    <a href="{{url('/'.$yt->categories[0]->slug.'/'.((!empty($yt->slug)) ? $yt->slug : $yt->id))}}" onClick="return ajaxRoute($(this).attr('href'))">
                                        <div class="item-details">
                                            <div class="item-title">
                                                {{check_value($yt->frontpage_title,$yt->title)}}
                                            </div>
                                            <div class="item-desc">
                                                {{check_value($yt->head,str_limit(preg_replace('#\<(.*?)\>#','', strip_tags($yt->body)), $limit = 150, $end = '...' ))}}
                                            </div>
                                        </div>
                                        <div class="item-img">
                                            {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" />--}}
                                            <img src="{{(!empty($yt->img)) ? get_img_url($yt->img) : asset('theme/images/no_photo.png')}}" height="250px"/>
                                        </div>
                                    </a>
                                @endif
                        @endif
                    </li>
                    {{--*/$i++/*--}}
                    @endforeach
                    <!-- END NEWS 1 -->
                </ul>
                <div class="fix"></div>
                <div id="preloader"></div>
            </div>
                <div class="fix"></div>
            <div class="item-show-more">
                @if($items[0]->categories[0]->name == "youtube")
                    <a onClick="loadRecords(this)" data-preloader="{{asset('theme/images/loading.GIF')}}" data-cat="{{'youtube'}}"
                       data-num="10" data-token="{{csrf_token()}}" data-url="{{action('WelcomeController@loadRecords')}}">{{trans('all.show_more')}}
                    </a>
                @else
                <a onClick="loadRecords(this)" data-preloader="{{asset('theme/images/loading.GIF')}}" data-cat="{{($items[0]->categories[0]->name == 'free_event' or
                        $items[0]->categories[0]->name == 'premium_event' ) ? 'events' : $items[0]->categories[0]->name}}"
                        data-num="10" data-token="{{csrf_token()}}" data-url="{{action('WelcomeController@loadRecords')}}">{{trans('all.show_more')}}
                </a>
                @endif
            </div>
        </div>
        @else
            no data.
        @endif
    </div>
    <div class="fix"></div>
@stop