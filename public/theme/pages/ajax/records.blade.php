@if(count($items) > 0)
    <?php $y = youtube(get_youtube_array($items)); $i=0; ?>
@foreach($items as $item)
    <li class="item-list">
        @if(isset($youtube_video) && $youtube_video == true)
            <div class="item-img"></div>
            <div class="data-wrap">
                @if(in_array(77,array_pluck($item->categories,'id')))
                    {!! youtubeVideo($item,true) !!}
                @endif
            </div>
        @else
            @if(get_youtube($item->body))
                {!! get_youtube($item->body) !!}
            @else
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
            @endif
        @endif
    </li>
    {{--*/$i++/*--}}
@endforeach
@endif