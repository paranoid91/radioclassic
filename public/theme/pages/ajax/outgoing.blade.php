{{--*/ $img = array(); $i=0;/*--}}
@if(count($playlist) > 0)
    @foreach($playlist as $play)
        <?php $data = unserialize($play->data); ?>
        <div class="radio-playlist-item">
            <ul>
                <li>
                    @if(count($data) > 0)
                        <div class="playlist-item-img">
                            @if(!empty($play->img))
                                <img src="{{$play->img}}" width="130"/>
                            @else
                                <?php $image = asset('theme/images/no_photo.png');?>
                                <img src="{{$image}}" width="130"/>
                            @endif
                            @if($play->download != 'null' && $play->download != '')
                                <br> <br>
                                <a href="{{$play->download}}" target="_blank"><img width="100px" src="{{asset('theme/images/download-on-itunes.png')}}"></a>
                            @endif
                        </div>
                        <div class="playlist-item-info">
                            <b>{{date('d.m.Y H:i',strtotime($play->timestamp))}}</b><br>
                            <b>{{validate_extra_field($data,'composer')}}</b>: <span>{{validate_extra_field($data,'title')}}</span><br>
                            <span>{{validate_extra_field($data,'local_name')}}</span><br>
                            @if(validate_extra_field($data,'maestro'))
                                Kapellimestari: <span>{{validate_extra_field($data,'maestro')}}</span><br>
                            @endif
                            @if(validate_extra_field($data,'performer'))
                                Esittäjä: <span>{{validate_extra_field($data,'performer')}}</span><br>
                            @endif
                            @if(validate_extra_field($data,'soloist'))
                                Solisti: <span>{{validate_extra_field($data,'soloist')}}</span><br>
                            @endif
                            @if(validate_extra_field($data,'label'))
                                Levy-yhtiö: <span>{{validate_extra_field($data,'label')}}</span><br>
                            @endif
                            @if(validate_extra_field($data,'album'))
                                Levy: <span>{{validate_extra_field($data,'album')}}</span><br>
                            @endif
                        </div>
                    @endif
                </li>
            </ul>
        </div>
        {{--*/$i++/*--}}
    @endforeach
    @else
    no data.
@endif