<div class="header-wrapper">
    <div class="header" @if($bg == true) style="position:relative;background-image:url('{{asset('theme/images/s1.png')}}')" @endif>
    <div class="container-fluid no-margin">
        <div class="row">
            <div class="top-logo-wrapper">
                <a class="navbar-brand" href="{{action('WelcomeController@index')}}" onClick="return ajaxRoute($(this).attr('href'))">
                    <div class="header-logo"></div>
                </a>
            </div>
            <div class="top-banner-wrapper">
                @if(isset($banners) && !empty($banners))
                    <div id="myCarousel" class="carousel slide bt-carousel carousel-fade" data-interval="10000" data-ride="carousel">
                        <div class="carousel-inner">
                            @for($i = 0; $i < count($banners); $i++)
                                @foreach($banners[$i]->categories as $cat)
                                    @if(isset($cat->slug) && $cat->slug == "top-banner")
                                        <div class="item {{ $i == 0 ? 'active' : '' }}">
                                            <a href="{{ $banners[$i]->url }}" target="_blank" class="top-banner-link">
                                                <img class="img-responsive top-banner-img" src="{{ $banners[$i]->banner }}" alt="{{ $banners[$i]->title }}" />
                                            </a>
                                        </div>
                                        <?php $GLOBALS["active_banners"] = true; ?>
                                    @endif
                                @endforeach
                            @endfor
                        </div>
                    </div>
                @endif
            </div>
            <div class="social-icons-wrapper">
                <div class="header-social">
                    <ul>
                        <li class="rodot-icon"><a href="http://www.radiot.fi/#!/kanava/classic" target="_blank"></a></li>
                        <li class="facebook-icon"><a href="https://www.facebook.com/radioclassicfi/" target="_blank" ></a></li>
                        <li class="twitter-icon"><a href="https://twitter.com/radioclassicfi" target="_blank"></a></li>
                        <li class="soundcloud-icon"><a href="https://soundcloud.com/radioclassicfi"  target="_blank"></a></li>
                        <li class="youtube-icon"><a href="http://www.youtube.com/user/radioclassicfi" target="_blank"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row no-padding">
            {{--<div class="top-ad-wrapper">
                <div class="top-ad-holder text-center">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-8409241209504529"
                         data-ad-slot="8736308251"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>--}}
        </div>
    </div>
        <nav class="navbar navbar-default navbar_menu" @if(!isset($GLOBALS["active_banners"])) {{ "style=margin-top:120px" }} @else <?php unset($GLOBALS["active_banners"]); ?> @endif>
            <div class="container-fluid no-padding">
                <div class="navbar-header">
                    <button type="button"
                            class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target="#collapsemenu"
                            aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{--<a class="navbar-brand" href="javascript:void('')" onClick="ajaxRoute('/', '/')">
                        <div class="header-logo"></div>
                    </a>--}}
                </div>
                <div class="collapse navbar-collapse" id="collapsemenu">
                    <ul class="nav navbar-nav">
                        @if(!empty($menu))
                            @foreach($menu as $k => $item)
                                <li {{ (isset($item['children']) ? 'class=dropdown' : '') }}>
                                    @if(isset($item['children']))
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" onClick="return false;">{{ $item['title'] }} <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown-menu">
                                            @for($i = 0; $i < count($item["children"]); $i++)
                                                <li class="dropdown">
                                                    <a href="{{ url($item["children"][$i]["superselect"]) }}" @if(strpos(url($item["children"][$i]["superselect"]),str_replace('http://','',url('/'))) === false) target="_blank" @else onClick="return ajaxRoute($(this).attr('href'), '{{ $item["children"][$i]["superselect"] }}');" @endif>{{ $item['children'][$i]["title"] }}</a>
                                                </li>
                                            @endfor
                                        </ul>
                                    @else
                                        <a href="{{ url(str_replace('http://www.','http://',$item["superselect"])) }}" @if(strpos(url($item["superselect"]),str_replace('http://','',url('/'))) === false) target="_blank" @else onClick="return ajaxRoute($(this).attr('href'),$(this).attr('href'));" @endif>{{ $item['title'] }}</a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                        <li class="top-search">
                            <div class="container-fluid no-padding">
                                <div class="row no-margin">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                        <i class="search-icon" onClick="$('#search_submit').click()"></i>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-top: 15px">
                                        <form name="search" onSubmit="searchAjax(this);return false;">
                                            <input type="text" name="search" value="Haku..." onClick="inputPlaceholder(this,'Haku...')"/>
                                            <input type="submit" name="search_submit" style="display:none;" id="search_submit"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>