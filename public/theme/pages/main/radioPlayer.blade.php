<div class="radio-player">
    <div class="radio-player-space">
        <div class="player-buttons">
            <table style="width:280px;">
                <tr>
                    <td>
                        <div class="play-pause">
                            <a onClick="playPause()" class="play"></a>
                        </div>
                    </td>
                    <td style="width:35px;display:block;"></td>
                    <td>
                        <input type="hidden" id="volume_value" name="volume_value" value="37"/>
                        <div id="sound_icon">
                            <span></span>
                        </div>
                    </td>
                    <td width="10px"></td>
                    <td width="60%">
                        <div id="volume"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="radio-player-playlist">
            <ul>
                <li class="accordion">
                    <div class="play-content">
                        <div class="button">
                            <a><span>{{trans('all.previous')}}</span></a>
                        </div>
                        <div class="desc prevSong">
                            <h3>{{$xmlPlaylist['previous']['composer']}}</h3>
                            <h5>{{$xmlPlaylist['previous']['title']}}</h5>
                        </div>
                    </div>
                </li>
                <li class="accordion active now-play-block">
                    <div class="play-content">
                        <div class="button">
                            <a><span>{{trans('all.now_playing')}}</span></a>
                        </div>
                        <div class="desc nowSong">
                            <h3>{{$xmlPlaylist['now']['composer']}}</h3>
                            <h5>{{$xmlPlaylist['now']['title']}}</h5>
                        </div>
                    </div>
                </li>
                <li class="accordion">
                    <div class="play-content">
                        <div class="button">
                            <a><span>{{trans('all.next')}}</span></a>
                        </div>
                        <div class="desc nextSong">
                            @if(!empty($xmlPlaylist['next']['composer']))
                            <h3>{{$xmlPlaylist['next']['composer']}}</h3>
                            <h5>{{$xmlPlaylist['next']['title']}}</h5>
                            @else
                                loading...
                            @endif
                        </div>
                    </div>
                </li>
                <li class="frequencies">
                    <div class="button">
                        <a><span>{{trans('all.frequencies')}}</span></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="radio-stations">
    @if(isset($xuina) && count($xuina) > 0)
        <div>
            <h3>{{$xuina[0]->title}}</h3>
            <div class="radio-wave">
               {!! $xuina[0]->body !!}
            </div>
        </div>
    @endif
</div>
<div id="radio_player_content">
    <audio id="audio_player" preload style="display:none;">
        <source src="http://stream.radioclassic.fi:8080/classic">
    </audio>
    <span id="duration"></span>
</div>
