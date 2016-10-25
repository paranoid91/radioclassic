@include('header')
<div class="content" id="content" style="background:#FFFFFF;margin:500px auto 0 auto !important;padding:20px !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="main-container-wrapper col-sm-9 col-md-9 col-lg-9">
                <div class="container-fluid no-padding">
                    <div class="read read-wrapper">
                        <h3>
                           @if(null !== ($request->session()->get('title')))
                               {{ $request->session()->get('title') }}
                           @endif
                        </h3>
                        <div class="read_content">
                        @if(null !== ($request->session()->get('img')))
                            <div class="main-img">
                                <img class="img-responsive" src="{{ base64_decode($request->session()->get('img')) }}" />
                            </div>
                        @endif
                        @if(null !== ($request->session()->get('youtube')))
                            <div class="main-img">
                                {!! $request->session()->get('youtube') !!}
                            </div>
                        @endif
                        @if(null !== ($request->session()->get('body')))
                                {!! $request->session()->get('body') !!}
                            @endif
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
                    </div>
                </div>
            </div>
            @include('theme.pages.ad')
        </div>
    </div>
</div>
@include('footer')