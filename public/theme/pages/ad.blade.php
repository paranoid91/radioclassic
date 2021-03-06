<div class="ad-container col-md-3 col-lg-3" {{ Route::getCurrentRoute()->uri() == '/' ? 'style=margin-left: -50px' : ''}}>
    <div class="container-fluid ad-wrapper no-padding">
        <div class="row ad-banner">
            <div class="row ad-main">
                @if(isset($banners) && !empty($banners))
                    @for($i = 0; $i < count($banners); $i++)
                        @foreach($banners[$i]->categories as $cat)
                            @if(isset($cat->slug) && $cat->slug == "right-banner")
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-12 ad-media-wr">
                                    <div class="">
                                        <a href="{{ $banners[$i]->url }}" target="_blank" class="top-banner-link">
                                            <img class="top-banner-img" width="{{ $banners[$i]->size_x }}" height="{{ $banners[$i]->size_y }}" src="{{ $banners[$i]->banner }}" alt="{{ $banners[$i]->title }}" />
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endfor
                @endif
                {{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-12 ad-media-wr">
                    <ins class="adsbygoogle"
                         style="display:inline-block;min-width:120px;max-width:300px;width:100%;height:250px",
                         data-ad-client="ca-pub-8409241209504529"
                         data-ad-slot="8736308251"
                         data-ad-format="rectangle"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>--}}
            </div>
        </div>
    </div>
    <div class="row ad-fb" style="margin: 0">
        <div class="fb-page" data-href="https://www.facebook.com/radioclassicfi/" data-tabs="timeline" data-width="260" data-small-header="false" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/radioclassicfi/"><a href="https://www.facebook.com/radioclassicfi/">Classic</a></blockquote></div></div>
    </div>
    @if( Route::getCurrentRoute()->uri() == '/')
        <div class="row" stlye="margin:5px 0 0 0">
            <div class="ad-tw">
                <a class="twitter-timeline" href="https://twitter.com/RadioClassicFI" data-widget-id="709354671752790016">Tweets by @RadioClassicFI</a>
            </div>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
        <div class="row ad-ins" style="margin-top: 15px">
            <p class="insta-title"><i class="fa fa-instagram"></i> Radioclassic on Instagram</p>
            <div id="instafeed"></div>
            <a href="http://instagram.com/radioclassicfi" class="insta-follow-button" target="_blank"><i class="fa fa-instagram"></i> Follow on Instagram</a>
        </div>
    @endif
</div>
</div>