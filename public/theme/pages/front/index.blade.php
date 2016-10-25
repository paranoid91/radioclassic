<!-- Template Name: Home Page -->
@extends('app')

@section("script")
  {{--  <script src="http://cdn.imnjb.me/libs/instafeed.js/1.3.2/instafeed.min.js"></script>
    <script type="text/javascript">
        var feed = new Instafeed({
            get: 'user',
            userId: '1776836807',
            clientId: '7321411abf3a4958b207ae2779422578',
            accessToken: '1776836807.7321411.06ce7ad98c1548ffb09b8fb75ff6696a',
            limit: 6
        });
        feed.run();
    </script>--}}
@endsection

@section('content')
    @include('theme.pages.main.news')
   {{-- @include('theme.pages.main.events')--}}
    {{--@include('theme.pages.main.video')--}}
    {{--@include('theme.pages.main.image')--}}
@stop