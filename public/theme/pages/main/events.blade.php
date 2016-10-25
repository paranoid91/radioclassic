w<div class="records">
    @if(count($events) > 0)
        <div class="records-list">
            <div class="records-title">
                <a href="{{action("WelcomeController@cat","events")}}" onClick="ajaxRoute($(this).attr('href'))">{!! trans('all.f_events') !!}</a>
            </div>

            <div class="records-content">
                <ul>
                    @foreach($events as $item)
                        <li class="item-list">
                            <a href="{{url('/'.$item->categories[0]->slug.'/'.((!empty($item->slug)) ? $item->slug : $item->id))}}" onClick="return ajaxRoute($(this).attr('href'))">
                                <div class="item-details">
                                    <div class="item-title">
                                        {{check_value($item->frontpage_title,$item->title)}}
                                    </div>
                                    <div class="item-desc">
                                        {{check_value($item->head,str_limit(preg_replace('#\<(.*?)\>#','', strip_tags($item->body)), $limit = 150, $end = '...' ))}}
                                    </div>
                                </div>
                                <div class="item-img">
                                    {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" />--}}
                                    <img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" height="250px"/>
                                </div>
                            </a>
                        </li>
                        @endforeach
                                <!-- END NEWS 1 -->
                </ul>
                <div id="preloader"></div>
            </div>

            <div class="item-show-more"><a href="{{action("WelcomeController@cat","events")}}" onClick="ajaxRoute($(this).attr('href'))">{{trans('all.show_more')}}</a></div>

        </div>
    @else
        no data.
    @endif
</div>
<div class="fix"></div>