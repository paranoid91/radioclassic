{{--*/	$gallery = facebookGallery('1506828172950270','8e5bc137b6199e5b5846561f174ecdae'); /*--}}
<div class="records">
    <div class="records-list">
        @if(count($gallery->photos->data) > 0)
            <div class="records-content">
                <ul class="gallery clearfix">
                    <!-- NEWS 1 -->
                    @foreach($gallery->photos->data as $data)
                        <li class="item-list">
                            <a href="http://graph.facebook.com/{{$data->id}}/picture" title="{{(isset($data->name)) ? $data->name : ''}}" rel="prettyPhoto[gallery]">
                                <div class="item-details">
                                    {{--<div class="item-date">{{trans('months.'.date('n',strtotime($gallery->photos->data[$i]->created_time))) .' '. date('d, Y',strtotime($gallery->photos->data[$i]->created_time))}}</div>--}}
                                    @if(isset($data->name))
                                        <div class="item-desc" style="padding-top:10px;font-weight:400;">
                                            {{$data->name}}
                                        </div>
                                    @endif
                                </div>
                                <div class="item-img">
                                    <img src="http://graph.facebook.com/{{$data->id}}/picture"/>
                                </div>
                            </a>
                        </li>
                        @endforeach
                                <!-- END NEWS 1 -->
                </ul>
                <div class="fix"></div>
            </div>
        @endif
    </div>
</div>
<div class="fix"></div>
<script>
    $(document).ready(function() {
        $("a[rel^='prettyPhoto']").prettyPhoto({overlay_gallery:false,animation_speed:'normal',slideshow:3000, autoplay_slideshow: true,social_tools:false});
    });
</script>