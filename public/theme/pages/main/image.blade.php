<?php	$gallery = facebookGallery('1506828172950270','8e5bc137b6199e5b5846561f174ecdae','.limit(4)'); ?>
<div class="records">
    <div class="records-list">
        <div class="records-title">
            <a href="javascript:void('')" onClick="ajaxRoute('/show/galleria','galleria')"><span>{{trans('all.photo_gallery')}}</span></a>
        </div>
        @if(count($gallery->photos->data) > 0)
        <div class="records-content">
            <ul>
                <!-- NEWS 1 -->
                {{--@foreach($gallery->photos->data as $data)
                <li class="facebook-gallery">
                    <a href="javascript:void('')" onClick="ajaxRoute('{{action("WelcomeController@ajaxCat","galleria")}}','/galleria')">
                        <div class="item-img">
                            <img src="http://graph.facebook.com/{{$data->id}}/picture" />
                            <div class="item-bg"></div>
                        </div>
                        <div class="item-info">
                            <div class="item-date">{{trans('months.'.date('n',strtotime($data->created_time))) .' '. date('d, Y',strtotime($data->created_time))}}</div>
                        </div>
                        @if(isset($data->name))
                        <div class="item-title">
                            {{$data->name}}
                        </div>
                        @endif
                    </a>
                </li>
                @endforeach--}}
                @for($i = 0; $i < 4; $i++)
                    @if(isset($gallery->photos->data[$i]))
                    <li class="item-list">
                        <a href="{{action('WelcomeController@show','show/galleria')}}" onClick="ajaxRoute($(this).attr('href'))">
                            <div class="item-details">
                                {{--<div class="item-date">{{trans('months.'.date('n',strtotime($gallery->photos->data[$i]->created_time))) .' '. date('d, Y',strtotime($gallery->photos->data[$i]->created_time))}}</div>--}}
                                @if(isset($gallery->photos->data[$i]->name))
                                    <div class="item-desc" style="padding-top:10px;">
                                        {{$gallery->photos->data[$i]->name}}
                                    </div>
                                @endif
                            </div>
                            <div class="item-img">
                                <img src="http://graph.facebook.com/{{$gallery->photos->data[$i]->id}}/picture"/>
                            </div>
                        </a>
                    </li>
                    @endif
                @endfor
                <!-- END NEWS 1 -->
            </ul>
            <div class="fix"></div>
        </div>
        @endif
        <div class="item-show-more"><a href="javascript:void(0)" onClick="ajaxRoute('/show/galleria','galleria')">{{trans('all.show_more')}}</a></div>
        {{--<div class="item-show-more"><a href="javascript:void(0)" onClick="ajaxRoute('{{action("WelcomeController@ajaxCat","galleria")}}','/galleria')">{{trans('all.show_more')}}</a></div>--}}
    </div>
</div>
<div class="fix"></div>