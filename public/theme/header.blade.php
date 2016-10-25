<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link href="{{ asset('/theme/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/theme/css/extra.css') }}" rel="stylesheet">
    <!-- PrettyPhoto Css -->
    <link href="{{ asset('/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome/font-awesome.min.css') }}">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('/js/jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/jquery-migrate-1.2.1.min.js') }}" async></script>
    <script src="{{ asset('/js/jquery/ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/jquery.prettyPhoto.js') }}" async></script>
    <script src="{{ asset('/js/backstretch.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap/moment-with-locales.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap/bootstrap-datetimepicker.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
    @if(permitSortNews() && isset($admin) && $admin === true)
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    @endif
    <title>{{get_title()}}</title>
    {!! get_meta() !!}
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @if(Route::getCurrentRoute()->uri() == '/')
    <script src="http://cdn.imnjb.me/libs/instafeed.js/1.3.2/instafeed.min.js"></script>
    <script type="text/javascript">
        var feed = new Instafeed({
            get: 'user',
            userId: 1302796146,
            clientId: '1b4f9eb4808147b8931e66529b5e28b1',
            accessToken: '1302796146.1677ed0.5ff4813d10eb46a5a8036e2cbc5693a1',
            limit: 6
        });
        feed.run();
    </script>
    @endif
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-36631111-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/fi_FI/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="wrapper container-fluid no-padding">
    <div id="load_screen">
        <div></div>
    </div>
    <div id="token" style="display:none;">{{csrf_token()}}</div>

    @if( !preg_match('/^is-admin\/preview-page/', Route::getCurrentRoute()->uri() ) )
        @include('theme.pages.main.radioPlayer')
    @endif
    <div class="container site_container" id="container">
        <!-- HEADER NAVIGATION -->
        @include('theme.pages.main.HeaderNav',['bg'=> false])
        {{--@if(Route::getCurrentRoute()->uri() == '/')--}}
            <div id="main_slider">
            </div>
            <div class="now-playing-space">
                <div class="now-playing-title">
                    <h3>{{trans('all.now_playing')}}</h3>
                    @if( !preg_match('/^is-admin\/preview-page/', Route::getCurrentRoute()->uri() ) )
                    <h1 class="composer">{{$xmlPlaylist['now']['composer']}}</h1>
                    <h1 class="mus-title">{{$xmlPlaylist['now']['title']}}</h1>
                    @endif
                </div>
            </div>
      {{--  @endif--}}
        @if( !preg_match('/^is-admin\/preview-page/', Route::getCurrentRoute()->uri() ) )
            <span id="musTitle" style="display: none">{{$xmlPlaylist['now']['title']}}</span>
        @endif
        <?php $slider = get_slider_items();?>
        <script>
            $(document).ready(function () {
                $('#main_slider').bgSlider({auto: true, changeTime: parseInt(<?php echo (get_setting('slider_time') * 1000);?>),images:<?php echo $slider;?>});
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#myCarousel').carousel({
                    interval: parseInt('<?php echo (get_setting('banner_time') * 1000);?>')
                });
            });
        </script>
        <div id="meta" style="display:none">
            {{json_encode(Config::get('registry'),JSON_UNESCAPED_UNICODE)}}
        </div>
        <script src="{{ asset('/theme/js/custom.js') }}"></script>
        <script src="{{ asset('/theme/js/ajax.js') }}"></script>