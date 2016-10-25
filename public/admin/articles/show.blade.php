@extends('theme.app')

@section('content')
    <div class="read">
        <h3>{{$item->title}}</h3>
        <div class="read_content">
            @if(count($images) > 0)<div class="main-img"><img src="{!!  get_img_url($images[0]->img)!!}" /></div> @endif
            {!! do_shortcode($item->body) !!}
        </div>
        <div class="fix"></div>
        <div class="share-buttons">
            <ul>
                <li><span>Share</span></li>
                <li class="facebook-icon-o"><a href="#"></a></li>
                <li class="twitter-icon-o"><a href="#"></a></li>
                <li class="google-icon-o"><a href="#"></a></li>
            </ul>
        </div>
        <div class="fix"></div>
        <div class="records">
            <div class="records-list">
                <div class="records-title">
                    <a href="#"><span>SIMILAR</span></a>
                </div>
                <div class="records-content">
                    <ul>
                        <!-- NEWS 1 -->
                        <li>
                            <div class="item-img">
                                <img src="{{asset('theme/images/news/n1.png')}}" />
                                <div class="item-bg"></div>
                            </div>
                            <div class="item-info">
                                <div class="item-date">November 10, 2015</div>
                                <div class="item-title">
                                    Astor Piazzolla
                                </div>
                                <div class="item-location">
                                    Tbilisi, Georgia
                                </div>
                            </div>
                            <div class="item-more">
                                <a href="#"><span>Read more</span></a>
                            </div>
                        </li>
                        <!-- END NEWS 1 -->
                        <!-- NEWS 2 -->
                        <li>
                            <div class="item-img">
                                <img src="{{asset('theme/images/news/n2.png')}}" />
                                <div class="item-bg"></div>
                            </div>
                            <div class="item-info">
                                <div class="item-date">November 10, 2015</div>
                                <div class="item-title">
                                    Astor Piazzolla
                                </div>
                                <div class="item-location">
                                    Tbilisi, Georgia
                                </div>
                            </div>
                            <div class="item-more">
                                <a href="#"><span>Read more</span></a>
                            </div>
                        </li>
                        <!-- END NEWS 2 -->
                        <!-- NEWS 3 -->
                        <li>
                            <div class="item-img">
                                <img src="{{asset('theme/images/news/n3.png')}}" />
                                <div class="item-bg"></div>
                            </div>
                            <div class="item-info">
                                <div class="item-date">November 10, 2015</div>
                                <div class="item-title">
                                    Astor Piazzolla
                                </div>
                                <div class="item-location">
                                    Tbilisi, Georgia
                                </div>
                            </div>
                            <div class="item-more">
                                <a href="#"><span>Read more</span></a>
                            </div>
                        </li>
                        <!-- END NEWS 3 -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="fix"></div>
    </div>
@stop