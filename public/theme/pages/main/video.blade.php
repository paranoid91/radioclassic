<div class="records">
    @if(count($videos) > 0)
        {{--*/ $y = youtube(get_youtube_array($videos)); $i=0;/*--}}
        <div class="records-list">
            <div class="records-title">
                <a href="javascript:void('')" onClick="ajaxRoute('{{action("WelcomeController@ajaxCat","youtube")}}','/youtube')">{!! trans('all.video_gallery') !!}</a>
            </div>

            <div class="records-content">
                <ul>
                    @foreach($videos as $item)
                        <li>
                            <div class="item-img">
                                {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : ((!empty($y->items[$i]->snippet->thumbnails->high->url)) ? $y->items[$i]->snippet->thumbnails->high->url : asset('theme/images/no_photo.png'))}}" />--}}
                                <div class="new-img-style" style="background-image: url({{(!empty($item->img)) ? get_img_url($item->img) : ((!empty($y->items[$i]->snippet->thumbnails->high->url)) ? $y->items[$i]->snippet->thumbnails->high->url : asset('theme/images/no_photo.png'))}});"></div>
                                <div class="item-bg"></div>
                            </div>
                            <div class="item-info">
                                {{(!empty($item->title)) ? $item->title : $y->items[0]->snippet->localized->title}}</div>
                                <div class="item-title">
                                    {{date('d' ,strtotime($item->published_at)) . " " .  trans('months.'.date('n',strtotime($item->published_at))) .' '. date('Y',strtotime($item->published_at))}}
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
                        {{--*/ $i++ /*--}}
                        @endforeach
                                <!-- END NEWS 1 -->
                </ul>
                <div id="preloader"></div>
            </div>

            <div class="item-show-more"><a href="javascript:void('')" onClick="ajaxRoute('{{action("WelcomeController@ajaxCat","youtube")}}','/youtube')">{{trans('all.show_more')}}</a></div>

        </div>
    @else
        no data.
    @endif
</div>
<div class="fix"></div>