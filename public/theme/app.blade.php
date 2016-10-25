{{--
@include('header')
<div class="content" id="content" @if(Route::getCurrentRoute()->uri() == '/')style="background:#FFFFFF;margin:30% auto 0 auto !important;padding:20px !important;"@endif>
    @yield('content')
</div>
@include('footer')
--}}

@include('header')
<div class="content" id="content" style="background:#FFFFFF;margin:500px auto 0 auto !important;padding:20px !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="main-container-wrapper col-sm-9 col-md-9 col-lg-9">
                @yield('content')
            </div>
            @include('theme.pages.ad')
        </div>
    </div>
</div>
@include('footer')
