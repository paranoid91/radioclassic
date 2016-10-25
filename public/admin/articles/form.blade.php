{{--*/ $parents = get_cat_by_parent(2) /*--}}

{!! Form::hidden('type',$type) !!}
<div class="row">
    <div class="col-xs-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('lang',trans('all.chose_language')) !!}
                    {!! Form::select('lang',get_languages(),$lang,['class'=>'form-control','style'=>'margin-top:0']) !!}
                </div>
            </div>
        </div>
        @if(count($parents) > 0)
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('cat',trans('all.main_category')) !!}<i class="required">*</i>
                        <select id="main_cat" name="cat[]" class="form-control" style="margin-top:0;">
                            <option value="">---</option>

                            @foreach($parents as $p)
                                <option value="{{$p['id']}}" {{($p['id'] == $parent || $p['id'] == $catid) ? 'selected' : ((($parent <= 0 and $catid <=0) && $p['id'] == 55) ? 'selected' : '')}} data-checked="{{$checked_cats}}" data-news="{{$news_id}}" data-route="{{ action('Admin\ArticlesController@getCats') }}" data-url="{{ action('Admin\ArticlesController@getFields') }}" data-token="{{csrf_token()}}" data-extra="{{$json_extra}}">{{trans('all.'.$p['name'])}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('published_at',trans('all.published_at')) !!}<i class="required">*</i>
                    {!! Form::text('published_at',$date,['class'=>'form-control','id'=>'datetimepicker1']) !!}
                </div>
            </div>
            @include('admin.articles.extra_fields.fields')
        </div>

        <div class="row" @if(Auth::user()->hasRole('author')) style="display:none" @endif>
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('author',trans('all.author')) !!}
                    {!! Form::text('author',$chose_author,['class'=>'form-control ajax_author','data-route'=>action('Admin\UsersController@getAjaxUserName'),'data-token'=>csrf_token()]) !!}
                    <div class="ajax_author_get ajax_drop"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('author',trans('all.chose_author')) !!}
                    {!! Form::selectMy('chose-author',$users,$chose_author,'<option>---</option>',['class'=>'form-control','onChange'=>'selectInput(this,"author")','style'=>'margin-top:0px;']) !!}
                </div>
            </div>
        </div>
        <div class="row image_buttons">
            <div class="col-sm-11">
                <div class="form-group">
                    <span>
                    <a class="btn btn-warning">1</a>
                    <a class="btn btn-success iframe-btn" href="{{ asset('/filemanager/dialog.php?type=1&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=UploadImage0') }}"><i class="fa fa-image"></i> {{trans('all.chose_img')}}</a>
                    <a class="btn btn-danger" data-id="0" onClick="removeImage(this)"><i class="fa fa-trash-o"></i> {{trans('all.remove')}}</a>
                    <a class="image_details btn btn-info" data-toggle="modal" data-target="#ImageEditModal0" ><i class="fa fa-edit"></i> {{trans('all.edit')}}</a>
                    </span>
                    <a class="btn btn-primary add_photo" data-url="{{action('Admin\ImagesController@imgField')}}" data-token="{{csrf_token()}}"><i class="fa fa-plus-square-o"></i> {{trans('all.add_more')}}</a>
                </div>

            </div>

            @if(count($image_gallery) > 1)
                {{--*/$i = 0/*--}}@foreach($image_gallery as $image)
                    @if(!empty($image['img']))
                        @if($i <> 0)
                        <div class="col-sm-11">
                            <div class="form-group">
                              <span>
                                <a class="btn btn-warning">{{$i + 1}}</a>
                                <a class="btn btn-success iframe-btn" href="{{ asset('/filemanager/dialog.php?type=1&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=UploadImage'.$i) }}"><i class="fa fa-image"></i> {{trans('all.chose_img')}}</a>
                                <a class="btn btn-danger" data-id="{{$i}}" onClick="removeImageMore(this)"><i class="fa fa-trash-o"></i> {{trans('all.remove')}}</a>
                                <a class="image_details btn btn-info" data-toggle="modal" data-target="#ImageEditModal{{$i}}" ><i class="fa fa-edit"></i> {{trans('all.edit')}}</a>
                              </span>
                            </div>
                        </div>
                        @endif
                            {{--*/ $i++ /*--}}
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-xs-6">
        <ul class="image_gallery">
            <li>
                <span class="UploadImage0" data-id="1"  data-toggle="modal" data-target="#ImageEditModal0">
                    @if(!empty($image_gallery[0]['img']))
                      <b class="btn btn-warning">1</b>
                      <img src="{{get_img_url($image_gallery[0]['img'])}}">
                    @endif
                </span>
                @include('admin.modals.image',['modal_id'=>'ImageEditModal','num'=>0])
            </li>
            <div class="fix"></div>

            @if(count($image_gallery) > 1)
                {{--*/$i = 0/*--}}@foreach($image_gallery as $image)
                    @if(!empty($image['img']))
                       @if($i <> 0)
                        <li>
                           <span class="UploadImage{{$i}}" data-id="{{$i + 1}}" data-toggle="modal" data-target="#ImageEditModal{{$i}}">
                             <b class="btn btn-warning">{{ $i + 1 }}</b>
                             <img src="{{get_img_url($image['img'])}}" >
                           </span>
                            @include('admin.modals.image',['modal_id'=>'ImageEditModal'.$i,'num'=>$i])
                        </li>
                        @endif
                        {{--*/ $i++ /*--}}
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>
<!--
<div class="row">
 <div class="col-sm-10">
     <div class="form-group">
         {!! Form::label('extra_fields[brightcove]',trans('all.brightcove'),['style'=>'float:left;']) !!}<div class="fix"></div>
         {!! Form::text('extra_fields[brightcove]',$brightcove,['class'=>'form-control video_type','id'=>'brightcove','style'=>'width:30%;float:left;']) !!}
         <a class="btn btn-success iframe-btn" href="http://new.gbtimes.ge/brightcove/videos" style="margin-left:5px;">Browse</a>
     </div>
 </div>
</div>

<div class="row">
 <div class="col-sm-12">
     <div class="form-group">

         {!! Form::label('extra_fields[embed_video]',trans('all.embed')) !!}
         {!! Form::textarea('extra_fields[embed_video]',$embed,['class'=>'form-control video_type','id'=>'embed','style'=>'width:100%;','rows'=>'5','cols'=>'60']) !!}
    </div>
    </div>
</div>-->
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('title',trans('all.title')) !!}<i class="required">*</i>
            {!! Form::text('title',null,['class'=>'form-control count_field','maxlength'=>'255']) !!}
            <small>Content limited to 255 characters, remaining: <span class="title_count">0</span></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('frontpage_title',trans('all.frontpage_title')) !!}
            {!! Form::text('frontpage_title',null,['class'=>'form-control count_field','maxlength'=>'55']) !!}
            <small>Content limited to 55 characters, remaining: <span class="frontpage_title_count">0</span></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('social_media_title',trans('all.social_media_title')) !!}
            {!! Form::text('social_media_title',null,['class'=>'form-control count_field','maxlength'=>'100']) !!}
            <small>Content limited to 100 characters, remaining: <span class="social_media_title_count">0</span></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('head',trans('all.short_desc')) !!}
            {!! Form::textarea('head',null,['class'=>'form-control','rows'=>5]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('body',trans('all.text')) !!}<i class="required">*</i>
            {!! Form::textarea('body',null,['class'=>'form-control tinymce']) !!}
        </div>
    </div>
</div>


<div class="row">

    <div class="col-xs-6">
        {!! $fields !!}
        <div id="extra_parent_fields"></div>
        <div id="extra_child_fields"></div>
        <div id="preloader"></div>
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    {!! Form::label('meta_key',trans('all.tags')) !!}
                    {!! Form::text('meta_key',null,['class'=>'form-control count_field ajax_tags','maxlength'=>100,'data-route'=>action('Admin\ArticlesController@getAjaxTags'),'data-token'=>csrf_token()]) !!}
                    <small>Content limited to 100 characters, remaining: <span class="meta_key_count">0</span></small>
                    <div class="ajax_tags_get ajax_drop"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    {!! Form::label('meta_desc',trans('all.meta_desc')) !!}
                    {!! Form::textarea('meta_desc',null,['class'=>'form-control','maxlength'=>150,'rows'=>5]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="checkbox-inline" >
                        {!! Form::hidden('menu_builder',0) !!}
                        {!! Form::checkbox('menu_builder',1) !!}
                        {{trans('all.show_in_menu_builder')}}
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    {!! Form::label('slug',trans('all.url').' ('.trans('all.auto_gen').')') !!}
                    {!! Form::text('slug',null,['class'=>'form-control','maxlength'=>255]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="competition" style="display:none;">
        <div class="col-xs-6">
            <div class="row box">
                <h3>{{trans('all.competition')}}</h3>

                <div class="col-sm-12">
                    <div class="form-group" id="competition">
                      @include('admin.articles.extra_fields.competition')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rubrics"  style="display:none;">
        <div class="col-xs-6">
            <div class="row box">
                <h3>{{trans('all.categories')}}</h3>

                <div class="col-sm-12">
                    <div class="form-group" id="rubrics">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {{--{!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}--}}
            {!! Form::submit( trans('all.save-bt') ,['class' => 'btn btn-primary']) !!}

        </div>
    </div>
</div>
<script>
    $('.title_count').text($('input[name="title"]').val().length);
    $('.frontpage_title_count').text($('input[name="frontpage_title"]').val().length);
    $('.social_media_title_count').text($('input[name="social_media_title"]').val().length);
    $('.meta_key_count').text($('input[name="meta_key"]').val().length);
</script>