<!-- HEADER NAVIGATION -->
@include('theme.pages.main.HeaderNav',['bg'=>false])

        <!-- FRONT PAGE FIRST VIEW -->

<div id="main_slider">
</div>
<div class="now-playing-space">
    <div class="now-playing-title">
        <h3>{{trans('all.now_playing')}}</h3>
        <h1>{{$xmlPlaylist['now']['title']}}</h1>
    </div>
</div>
<div class="content" style="background:#FFFFFF;margin:30% auto 0 auto !important;padding:20px !important;" >
@include('theme.pages.main.news')
@include('theme.pages.main.events')
@include('theme.pages.main.video')
@include('theme.pages.main.image')
</div>
<script src="{{ asset('/theme/js/custom.js') }}"></script>
<script src="{{ asset('/theme/js/ajax.js') }}"></script>
