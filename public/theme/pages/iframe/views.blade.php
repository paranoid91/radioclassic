@include('theme.pages.main.HeaderNav',['bg'=>true])

@section('meta_tags')

    @if(in_array(77,array_pluck($item->categories,'id')))

        <link rel="canonical" href="{{ \Request::url() }}">

        <!-- Social: Facebook / Open Graph -->
        {{--<meta property="fb:admins" content="579622216,709634581">--}}
        {{--<meta property="fb:app_id" content="1389892087910588">--}}
        <meta property="og:url" content="{{ \Request::url() }}">
        <meta property="og:type" content="video">
        <meta property="og:title" content="{{$item->title}}">
        <?php
        $videourl = unserialize($item->extra_fields);
        $videoID = explode('=', $videourl['youtube'] );
        $videoID = explode('&',$videoID[1]);
        ?>
        <meta property="og:video" content="{{ $videourl['youtube'] }}">
        <meta property="og:video:type" content="application/x-shockwave-flash">
        <meta property="og:image" content="http://img.youtube.com/vi/{{ $videoID[0] }}/0.jpg"/>
        <meta property="og:site_name" content="RADIO CLASSIC">

        <!-- Social: Google+ / Schema.org  -->
        <meta itemprop="name" content="{{$item->title}}">
        <meta itemprop="description" content="{{ $videourl['youtube'] }}">
        <meta itemprop="image" content="http://img.youtube.com/vi/{{ $videoID[0] }}/0.jpg">

    @else

        {{--<!-- SEO -->--}}
        @if(!empty($item->body))
            <meta name="description" content="{{ str_limit(preg_replace('/(<.*?>)|(&.*?;)/', '', strip_tags($item->body)), $limit = 200, $end = '...' ) }} ">
        @endif
        <link rel="canonical" href="{{ \Request::url() }}">



        <!-- Social: Facebook / Open Graph -->
        {{--<meta property="fb:admins" content="579622216,709634581">--}}
        {{--<meta property="fb:app_id" content="1389892087910588">--}}
        <meta property="og:url" content="{{ \Request::url() }}">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{$item->title}}">
        @if(count($images) > 0)
            <meta property="og:image" content="{!!  get_img_url($images[0]->img) !!}"/>
        @endif
        <meta property="og:description" content="{{ str_limit(preg_replace('/(<.*?>)|(&.*?;)/', '', strip_tags($item->body)), $limit = 200, $end = '...' ) }}">
        <meta property="og:site_name" content="RADIO CLASSIC">

        <!-- Social: Google+ / Schema.org  -->
        <meta itemprop="name" content="{{$item->title}}">
        <meta itemprop="description" content="{{ str_limit(preg_replace('/(<.*?>)|(&.*?;)/', '', strip_tags($item->body)), $limit = 200, $end = '...' ) }}">
        @if(count($images) > 0)
            <meta itemprop="image" content="{!!  get_img_url($images[0]->img) !!}">
        @endif

    @endif

@stop
<div class="content" id="content" {{--@if(Route::getCurrentRoute()->uri() == '/')--}}style="background:#FFFFFF;margin:500px auto 0 auto !important;padding:20px !important;"{{--@endif--}}>
    <div class="container-fluid no-padding" style="margin-top: 80px">
        <div class="row {{ Route::getCurrentRoute()->uri() == '/' ? "" : "add-margins" }}">
            <div class="main-container-wrapper col-md-9 col-lg-9">
                <div class="content">
                    <div class="read">
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
                                        <div class="item-body-wrapper">
                                            {!! do_shortcode($item->body) !!}
                                        </div>
                                    @endif
                                @endif
                            @endif
                            <div class="fix"></div>
                        </div>
                        <div class="fix"></div>
                        <div class="share-buttons">
                            <ul>
                                <li><span>Jaa</span></li>
                                <li class="facebook-icon-o"><a href="http://www.facebook.com/sharer.php?u={{ Request::url() }}"></a></li>
                                <li class="twitter-icon-o"><a href="https://twitter.com/intent/tweet?url={{ Request::url() }}&amp;text={{$item->title}}&amp;via=radioclassic.fi"></a></li>
                                <li class="google-icon-o"><a href="https://plus.google.com/share?url={{ Request::url() }}"></a></li>
                            </ul>
                        </div>
                        <div class="fix"></div>
                        <div class="records">
                            @if(count($items) > 0)
                                {{--*/ $y = youtube(get_youtube_array($items)); $i=0;/*--}}
                                <div class="records-list">
                                    <div class="records-title">
                                        <a href="#"><span>{{trans('all.similar')}}</span></a>
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
                                                            {{(!empty($item->title)) ? $item->title : $y->items[0]->snippet->localized->title}}
                                                        </div>
                                                        {{--<div class="item-title">{{trans('months.'.date('n',strtotime($item->published_at))) .' '. date('d, Y',strtotime($item->published_at))}}</div>--}}
                                                        <div class="item-title">{{date('d' ,strtotime($item->published_at)) . " " .  trans('months.'.date('n',strtotime($item->published_at))) .' '. date('Y',strtotime($item->published_at))}}</div>
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
                                        <div class="fix"></div>
                                        <div id="preloader"></div>
                                    </div>

                                    <div class="item-show-more"><a onClick="loadRecords(this)" data-preloader="{{asset('theme/images/loading.GIF')}}" data-cat="{{($items[0]->categories[0]->name == 'free_event' or $items[0]->categories[0]->name == 'premium_event') ? 'events' : $items[0]->categories[0]->name}}" data-num="3" data-token="{{csrf_token()}}" data-url="{{action('WelcomeController@loadRecords')}}">{{trans('all.show_more')}}</a></div>

                                </div>
                            @endif
                        </div>
                        <div class="fix"></div>
                    </div>
                </div>
            </div>
            @include('theme.pages.ad')
        </div>
    </div>
</div>
</div>
<script src="{{ asset('/theme/js/custom.js') }}"></script>
<script src="{{ asset('/theme/js/ajax.js') }}"></script>
