@extends('theme.app')

@section('content')
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
                            <li class="item-list">
                                <a href="{{url('/'.$items[$i]->categories[0]->slug.'/'.((!empty($items[$i]->slug)) ? $item->slug : $items[$i]->id))}}" onClick="return ajaxRoute($(this).attr('href'))">
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
    <div class="fix"></div>
@stop