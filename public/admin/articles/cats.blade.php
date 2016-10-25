@if(count($cats) > 0)
    @if(count($item) > 0)
        {{--*/ $cat_array = array_pluck($cats,'id') /*--}}
        {{--*/ $in_array = $item->categories()->select('cat_id')->whereIn('cat_id',$cat_array)->get()->toArray() /*--}}

        {{--*/ $checked_array = array_pluck($in_array,'cat_id') /*--}}
    @endif
    @foreach($cats as $key=>$cat)
        <label class="checkbox-inline" >
            @if(count($item) > 0)
                @if(in_array($cat['id'],$checked_array))
                    {{--*/ $checked = true /*--}}
                @else
                    {{--*/ $checked = false /*--}}
                @endif
                @if(count($checked_cats) > 0)
                    @if(in_array($cat['id'],$checked_cats))
                        {{--*/ $checked = true /*--}}
                    @endif
                @endif
            @elseif(count($checked_cats) > 0)
                @if(in_array($cat['id'],$checked_cats))
                    {{--*/ $checked = true /*--}}
                @else
                    {{--*/ $checked = false /*--}}
                @endif
            @endif

            {!! Form::checkbox('cat[]',$cat['id'],$checked,['data-url'=>action('Admin\\ArticlesController@getFields'),'data-token'=>csrf_token(),'data-news'=>$news_id,'class'=>'child_cat','onClick'=>'getFields("'.$cat["id"].'","'.action('Admin\\ArticlesController@getFields').'","'.csrf_token().'","'.$news_id.'",$("#main_cat option:selected").data("extra"),this)']) !!}  {{get_trans($cat['name'])}}
        </label>

    @endforeach
    <script>
        var children = $('.child_cat').length;
        var extra_fields = $("#main_cat option:selected").data("extra");
        for(var i=0;i<children;i++){
            if($('.child_cat:eq('+i+'):checked').val() > 0){
                var route = $('.child_cat:eq('+i+'):checked').data("route");
                var url = $('.child_cat:eq('+i+'):checked').data("url");
                var token = $('.child_cat:eq('+i+'):checked').data("token");
                var news_id = $('.child_cat:eq('+i+'):checked').data("news");
                getFields($('.child_cat:eq('+i+'):checked').val(),url,token,news_id,extra_fields,$('.child_cat:eq('+i+')'));
            }

        }
        $("#rubrics label").click(function(){
            if($('#rubrics input:checked').val() == 82){
                $('input[name="type"]').val("horoscope");
            }else if($('.video_type:eq(1)').val() != "" || $('.video_type:eq(0)').val() != ""){
                $('input[name="type"]').val("video");
            }else if($('.image_buttons > div').length > 1){
                $('input[name="type"]').val("photogallery");
            }else{
                $('input[name="type"]').val("article");
            }


        });
    </script>
@endif
