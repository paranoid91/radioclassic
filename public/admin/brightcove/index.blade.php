<html>
<head>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<style>
    .container{
        max-width:1000px !important;
        width:100%;
        margin:10px 0 10px 0 !important;
        padding:10px 0 10px 0 !important;
    }
     ul.items{
        margin:0;
        padding:0;
        list-style:none;
         display:table;
    }
    ul.items li{
        width:275px;
        text-align:center;
        display:inline-block;
        border-bottom:1px solid #e7e7e7;
        padding:10px 0 10px 0;
    }
    .attach-btn {
        -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
        -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
        box-shadow:inset 0px 1px 0px 0px #ffffff;
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #f6f6f6));
        background:-moz-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:-webkit-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:-o-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:-ms-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0);
        background-color:#ffffff;
        -moz-border-radius:6px;
        -webkit-border-radius:6px;
        border-radius:6px;
        border:1px solid #dcdcdc;
        display:inline-block;
        cursor:pointer;
        color:#666666;
        font-family:Arial;
        font-size:15px;
        padding:6px 24px;
        text-decoration:none;
        text-shadow:0px 1px 0px #ffffff;
    }
    .attach-btn:hover {
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f6f6f6), color-stop(1, #ffffff));
        background:-moz-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
        background:-webkit-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
        background:-o-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
        background:-ms-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
        background:linear-gradient(to bottom, #f6f6f6 5%, #ffffff 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f6f6f6', endColorstr='#ffffff',GradientType=0);
        background-color:#f6f6f6;
    }
    .attach-btn:active {
        position:relative;
        top:1px;
    }
    .video_attach{
        margin-top:5px;
    }
    .video_name{
        margin:5px;
    }
    .fix{
        clear:both;
    }
    .video_name{
        font-size:13px !important;
    }
    a:hover{
        text-decoration:none !important;
    }
    .filter{
        width:600px;
        margin:0 auto;
    }
</style>

    <script src="{{ asset('/js/jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/jquery-migrate-1.2.1.min.js') }}"></script>
</head>
<body>
<div class="container">
    <div class="filter">
        {!! Form::open(['method'=>'post','action'=>'Admin\ArticlesController@brightCove']) !!}
        {!! Form::text('search_video',$search_video,['class'=>'form-control','style'=>'width:30%;float:left;','placeholder'=>'Keywords']) !!}
        {!! Form::select('type',$type,$selected,['class'=>'form-control','style'=>'width:30%;float:left;margin-left:10px;']) !!}
        {!! Form::input('submit','filter_video','Filter',['class'=>'btn btn-success','style'=>'width:16%;margin-left:10px;']) !!}
        {!! Form::input('submit','reset_video','Reset',['class'=>'btn btn-danger reset','style'=>'width:16%;margin-left:10px;']) !!}
        {!! Form::close() !!}
    </div>
    <div class="fix"></div>
    <center>{!! str_replace('/?', '?', $paging->render()) !!}</center>

<ul class="items">
    @foreach($content as $key=>$item)

       @foreach($item->items as $item)
            <li>
                <div class="video_name">{{$item->name}}</div>
                <div class="video_thumb"><img src="{{$item->thumbnailURL}}"></div>
                <div class="video_attach">
                   <a href="javascript:void('')" class="attach-btn" data-id="{{$item->id}}">Attach</a>
                </div>
            </li>
       @endforeach
    @endforeach

</ul>
    <div class="fix"></div>
</div>
<script>
    $('.attach-btn').click(function(){
         var pr = window.parent;
         var brightcove = $('#brightcove',pr.document);
         brightcove.val($(this).data('id')).trigger('change');
         $('input[name="type"]',pr.document).val("video");
         parent.jQuery.fancybox.close();
    });
    $('.reset').click(function(){
         $('input[name="search_video"]').val("");
         $('select[name="type"]').val("");
    });
</script>
</body>
</html>