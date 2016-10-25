<div class="container-fluid no-padding">

    <!-- Banner Space -->
    {{--    <div class="row">
            <div class="col-lg-12 banner-wr">
                <div class="banner table">
                    <div class="banner-space table-row">
                        <div class="table-cell">
                            <a href="#">
                                ADS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
            <!-- End Banner Space -->

    <div class="container-fluid no-padding">
        <div class="records">
            @if(count($news) > 0)
                <div class="records-list">
                    <div class="records-title">
                        <a href="{{action('WelcomeController@showCat','news')}}" onClick="ajaxRoute($(this).attr('href'))">{!! trans('all.f_news') !!}</a>
                    </div>

                    <div class="records-content">
                        <ul>
                            @if(permitSortNews() && isset($admin) && $admin === true)
                                @if(session('msg'))
                                    <div class="alert alert-success text-center"><h4>{{session('msg')}}</h4></div>
                                @endif
                                <form action="" id="form-sort-news" method="POST" accept-charset="UTF-8" name="sort_news_form">
                                    {{ csrf_field() }}
                                    <ul id="sortable-news">
                                    @foreach($news as $n)
                                        <li class="item-list" data-id="{{ $n->id }}">
                                            <a href="{{ url("is-admin/articles/". $n->id ."/edit") }}">
                                                <div class="item-details">
                                                    <div class="item-title">
                                                        {{check_value($n->frontpage_title,$n->title)}}
                                                    </div>
                                                    <div class="item-desc">
                                                        {{check_value(strip_tags($n->head),str_limit(preg_replace('#\<(.*?)\>#','',strip_tags($n->body)), $limit = 150, $end = '...' ))}}
                                                    </div>
                                                </div>
                                                <div class="item-img">
                                                    <img src="{{(!empty($n->img)) ? get_img_url($n->img) : asset('theme/images/no_photo.png')}}" height="250px"/>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                                    <div class="form-group">
                                        <input type="submit" id="submit-sortnews" name="submit-sortnews" class="btn btn-default btn-block" value="Save"/>
                                    </div>
                                </form>
                            @else
                                @foreach($news as $item)
                                    <li class="item-list">
                                        @if(get_youtube($item->body))
                                            {!! get_youtube($item->body) !!}
                                        @else
                                            <a href="{{url('/'.$item->categories[0]->slug.'/'.((!empty($item->slug)) ? $item->slug : $item->id))}}" onClick="return ajaxRoute($(this).attr('href'))">
                                                <div class="item-details">
                                                    <div class="item-title">
                                                        {{check_value($item->frontpage_title,$item->title)}}
                                                    </div>
                                                    <div class="item-desc">
                                                        {{check_value(strip_tags($item->head),str_limit(preg_replace('#\<(.*?)\>#','',strip_tags($item->body)), $limit = 150, $end = '...' ))}}
                                                    </div>
                                                </div>
                                                <div class="item-img">
                                                    {{--<img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" />--}}
                                                    <img src="{{(!empty($item->img)) ? get_img_url($item->img) : asset('theme/images/no_photo.png')}}" height="250px"/>
                                                </div>
                                            </a>
                                        @endif
                                    </li>
                                    @endforeach
                                    <!-- END NEWS 1 -->
                            @endif
                        </ul>
                        <div id="preloader"></div>
                    </div>

                    @if(!permitSortNews() && !isset($admin))
                    <div class="item-show-more"><a href="javascript:void('')" onClick="ajaxRoute('news','/news')">{{trans('all.show_more')}}</a></div>
                    @endif
                </div>
            @else
                no data.
            @endif
        </div>

    </div>
    <div class="fix"></div>
</div>
