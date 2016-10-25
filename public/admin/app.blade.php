<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/admin/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/admin/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/admin/menu/jquery.domenu-0.48.53.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <!--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="{{ asset('/css/font-awesome/font-awesome.min.css') }}">

    <link href="{{ asset('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/jquery.fancybox-1.3.4.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{ asset('/js/jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/ui/jquery-ui.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/js/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap/moment-with-locales.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap/bootstrap-datetimepicker.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/js/jquery/jquery.fancybox-1.3.4.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.iframe-btn').fancybox({
                'width'		: 900,
                'height'	: 600,
                'type'		: 'iframe',
                'autoScale'    	: false
            });

        });
    </script>

    <script type="text/javascript" src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: "textarea.tinymce",theme: "modern",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "Convert emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "Convert | link unlink anchor | image media imgal | boldcolor forecolor backcolor  | print preview code | fontselect fontsizeselect",
            image_advtab: true ,
            filemanager_access_key:"baa950b9ec364447b677a1fa7cda724b" ,
            external_filemanager_path:"{{ asset('filemanager') }}/",
            filemanager_title:"Filemanager" ,
            external_plugins: { "filemanager" : "{{ asset('/filemanager/plugin.min.js') }}", "Convert" : "{{ asset('/js/convert/plugin.min.js') }}"}
        });
    </script>

</head>
<body class="{{(strpos(Route::getCurrentRoute()->uri(),'auth')) ? 'body-img' : ''}}">
@include('nav')
<div class="container">

   <div class="{{(isset($_COOKIE['nav_bar']) != false) ? 'topSide' : 'leftSide'}} "><!--class="leftSide"-->
        @if(!Auth::guest())
            @include('admin.block')
        @endif
   </div>
   <div class="{{(strpos(Route::getCurrentRoute()->uri(),'auth')) ? 'centerSide' : ((isset($_COOKIE['nav_bar']) != false) ? 'middleSide':'rightSide')}}">
       <div id="alert-messages">@include('flash::message')</div>
       <div class="content">
           @yield('content')
       </div>

    </div>
</div>

<script src="{{ asset('/js/custom.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/menu/jquery.domenu-0.48.53.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });
        $('#datetimepicker3').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });
    });
</script>


</body>
</html>
