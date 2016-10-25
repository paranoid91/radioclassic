<!-- Main slider -->
<div class="main-slider">
    <div class="slider-space">
        <div class="slide-title">
            <h1>{{trans('all.now_playing')}}</h1>
            <h4>{{$xmlPlaylist['now']['title']}}</h4>
        </div>
    </div>
</div>
<script>
    //background slider
    $('.first-view .main-slider').backstretch([
        "{{asset('theme/images/s1.png')}}",
        "{{asset('theme/images/s2.png')}}",
        "{{asset('theme/images/s3.png')}}",
        "{{asset('theme/images/s5.jpg')}}"
    ], {duration: 5000, fade: 750});
</script>