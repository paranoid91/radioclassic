<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('lang',trans('all.chose_language')) !!}
            {!! Form::select('lang',get_languages(),$lang,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('published_at',trans('all.published_at')) !!}
            {!! Form::text('published_at',$date,['class'=>'form-control','id'=>'datetimepicker1']) !!}
        </div>
    </div>
</div>

<div class="row" @if(Auth::user()->hasRole('author')) style="display:none" @endif>
    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('author',trans('all.author')) !!}
            {!! Form::text('author',$chose_author,['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('author',trans('all.chose_author')) !!}
            {!! Form::selectMy('chose-author',$users,$chose_author,'<option>---</option>',['class'=>'form-control','onChange'=>'selectInput(this,"author")','style'=>'margin-top:0px;']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('title',trans('all.title')) !!}
            {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xs-6">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('body',trans('all.text')) !!}
                    {!! Form::textarea('body',null,['class'=>'form-control tinymce']) !!}
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
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    {!! Form::label('meta_key',trans('all.meta_key')) !!}
                    {!! Form::text('meta_key',null,['class'=>'form-control','maxlength'=>100]) !!}
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
    </div>
    <div class="col-xs-6">
        <div class="row box" style="padding-right:10px;margin-top:25px;">
            <h3>{{trans('images.images')}}</h3>
            <div id="gallery">
                @if(count($images) > 0)
                    {{--*/ $i = 0 /*--}}@foreach($images as $key=>$img) {{--*/ $i++ /*--}}
                    <div class="form-group">
                        <div class="row">
                            {{--*/ $image = (strpos($img,'/') === false) ? url().'/uploads/gallery/old/'.$img : $img /*--}}
                            <div class="col-sm-5">{!! Form::text('img_title[]',$img_title[$key],['class'=>'form-control','placeholder'=>trans('images.title')]) !!}</div>
                            <div class="col-sm-4">{!! Form::text('images[]',$image,['class'=>'form-control','placeholder'=>'image','id'=>trans('all.image')]) !!}</div>
                            <div class="col-sm-2"><a class="btn btn-warning iframe-btn" href="{{ asset('/filemanager/dialog.php?type=1&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=image'.$i.'&wm=true') }}">{{trans('all.image')}}</a></div>
                            <div class="col-sm-1 right"><a onClick="remImageField(this)" class="remove"><i class="fa fa-times"></i></a></div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5">
                                {!! Form::input('text','img_title[]',null,['class'=>'form-control','placeholder'=>trans('images.title')]) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! Form::input('text','images[]',null,['class'=>'form-control','placeholder'=>trans('all.image'),'id'=>'image1']) !!}
                            </div>
                            <div class="col-sm-2"><a class="btn btn-warning iframe-btn" href="{{ asset('/filemanager/dialog.php?type=1&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=image1&wm=true') }}">{{trans('all.image')}}</a></div>
                            <div class="col-sm-1 right"><a onClick="remImageField(this)" class="remove"><i class="fa fa-times"></i></a></div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    {!! Form::button('<i class="fa fa-plus"></i> '.trans('images.more').'',['class' => 'btn btn-success right','onClick'=>'addImageField("gallery","'.trans("images.title").'","'.trans("all.image").'")']) !!}
                </div>
            </div>
        </div>

    </div>

</div>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>
