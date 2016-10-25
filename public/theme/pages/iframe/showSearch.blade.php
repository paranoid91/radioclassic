{{--@include('theme.pages.main.HeaderNav',['bg'=>true])--}}
@extends('theme.app')
@section('content')
    <div class="content">
        <div class="records">
            @if(count($items) > 0)
                {{--*/ $y = youtube(get_youtube_array($items)); $i=0;/*--}}
                <div class="records-list">
                    <div class="records-title">
                        <a href="javascript:void('')">{{$text}}</a>
                    </div>
                    <div class="records-content">
                        <ul>
                            @foreach($items as $item)
                                <li>
                                    <div class="item-img">
                                        {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : ((!empty($y->items[$i]->snippet->thumbnails->high->url)) ? $y->items[$i]->snippet->thumbnails->high->url : asset('theme/images/no_photo.png'))}}" />--}}
                                        <div class="new-img-style" style="background-image: url({{(!empty($item->img)) ? get_img_url($item->img) : ((!empty($y->items[$i]->snippet->thumbnails->high->url)) ? $y->items[$i]->snippet->thumbnails->high->url : asset('theme/images/no_photo.png'))}})"></div>
                                        <div class="item-bg"></div>
                                    </div>
                                    <div class="item-info">
                                        <div class="item-date">
                                            {{(!empty($item->title)) ? $item->title : $y->items[$i]->snippet->localized->title}}
                                        </div>
                                        <div class="item-title">
                                            {{date('d' ,strtotime($item->published_at)) . " " .  trans('months.'.date('n',strtotime($item->published_at))) .' '. date('Y',strtotime($item->published_at))}}</div>em-date">{{trans('months.'.date('n',strtotime($item->published_at))) .' '. date('d, Y',strtotime($item->published_at))}}
                                    </div>
                                        @if(count(unserialize($item->extra_fields)) > 0)
                                            @if(validate_extra_field(unserialize($item->extra_fields),'event_location'))
                                                <div class="item-location">
                                                    {{validate_extra_field(unserialize($item->extra_fields),'event_location')}}, {{trans('all.finland')}}
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="item-more">
                                        @if(count($item->categories) > 0)
                                            {{--*/$a=0/*--}}
                                            @foreach($item->categories as $cats) {{--*/$a++/*--}}
                                            @if($a <= 1)
                                                <a href="javascript:void('')" onClick="ajaxRoute('{{action('WelcomeController@ajaxShow',[$cats->slug,((!empty($item->slug)) ? $item->slug : $item->id)])}}','/{{$cats->slug}}/{{((!empty($item->slug)) ? $item->slug : $item->id)}}')"><span>{{trans('all.read_more')}}</span></a>
                                            @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </li>
                                {{--*/$i++/*--}}
                                @endforeach
                                        <!-- END NEWS 1 -->
                        </ul>
                        <div class="fix"></div>
                        <div id="preloader"></div>
                    </div>
                    <div class="fix"></div>
                    @if(count($items) > 8)
                        <div class="item-show-more"><a onClick="loadRecords(this)" data-preloader="{{asset('theme/images/loading.GIF')}}" data-cat="{{$text}}" data-num="9" data-token="{{csrf_token()}}" data-url="{{action('WelcomeController@loadSearch')}}">{{trans('all.show_more')}}</a></div>
                    @endif
                </div>
            @else
                no data.
            @endif
        </div>
    </div>
    <div class="fix"></div>
    <script src="{{ asset('/theme/js/custom.js') }}"></script>
    <script src="{{ asset('/theme/js/ajax.js') }}"></script>
@stop