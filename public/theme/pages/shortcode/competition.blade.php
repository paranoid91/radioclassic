<?php $competition = getCompetitions();?>
@if(count($competition) > 0)
    <div class="records">
        @if(count($competition) > 0)
            <div class="records-list">
                <div class="records-content">
                    <ul>
                        @foreach($competition as $item)
                            <li>
                                <div class="item-img">
                                    {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" />--}}
                                    <div class="new-img-style" style="background-image: url('{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}')"></div>
                                    <div class="item-bg"></div>
                                </div>
                                <div class="item-info">
                                    <div class="item-date">{{$item->title}}</div>
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
                                    <a href="{{action('WelcomeController@show',[$item->categories[0]->slug,((!empty($item->slug)) ? $item->slug : $item->id)])}}" onClick="ajaxRoute($(this).attr('href'))"><span>{{trans('all.read_more')}}</span></a>
                                </div>
                            </li>
                            @endforeach
                                    <!-- END NEWS 1 -->
                    </ul>
                    <div id="preloader"></div>
                </div>
            </div>
        @else
            no data.
        @endif
    </div>
    <div class="fix"></div>
@endif