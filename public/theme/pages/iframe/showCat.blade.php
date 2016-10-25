@include('theme.pages.main.HeaderNav',['bg'=>true])
<div class="content">
    <div class="records">
        @if(count($items) > 0)
            {{--*/ $y = youtube(get_youtube_array($items)); $i=0;/*--}}
            <div class="records-list">
                @if(count($items[0]->categories) > 0)
                    @if(!empty($items[0]->categories[0]->name))
                        <div class="records-title">
                            <a href="#">{!! ($items[0]->categories[0]->name == 'free_event' or $items[0]->categories[0]->name == 'premium_event') ? trans('all.f_events') : trans('all.f_'.$items[0]->categories[0]->name) !!}</a>
                        </div>
                    @endif
                @endif
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
                                    <a href="javascript:void('')" onClick="ajaxRoute('{{action('WelcomeController@ajaxShow',[$item->categories[0]->slug,((!empty($item->slug)) ? $item->slug : $item->id)])}}','/{{$item->categories[0]->slug}}/{{((!empty($item->slug)) ? $item->slug : $item->id)}}')"><span>{{trans('all.read_more')}}</span></a>
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
                <div class="item-show-more"><a onClick="loadRecords(this)" data-preloader="{{asset('theme/images/loading.GIF')}}" data-cat="{{($items[0]->categories[0]->name == 'free_event' or $items[0]->categories[0]->name == 'premium_event') ? 'events' : $items[0]->categories[0]->name}}" data-num="9" data-token="{{csrf_token()}}" data-url="{{action('WelcomeController@loadRecords')}}">{{trans('all.show_more')}}</a></div>

            </div>
        @else
            no data.
        @endif
    </div>
    <div class="fix"></div>
</div>
<script src="{{ asset('/theme/js/custom.js') }}"></script>
<script src="{{ asset('/theme/js/ajax.js') }}"></script>

