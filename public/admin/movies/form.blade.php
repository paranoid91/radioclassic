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

<div class="row" style="margin-bottom:15px;">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('cat',trans('all.category')) !!}

            {!! Form::selectChild('cat',$cats,$selected,['class'=>'controls form-control']) !!}
        </div>
    </div>
</div>

<div class="row" @if(Auth::user()->hasRole('Author')) style="display:none" @endif>
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
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('body',trans('all.text')) !!}
            {!! Form::textarea('body',null,['class'=>'form-control tinymce']) !!}
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xs-6">
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <a class="btn btn-warning iframe-btn" href="{{ asset('/filemanager/dialog.php?type=1&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=UploadImage') }}">Upload Image</a><br><br>
                    {!! Form::label('img','Image') !!}{!! Form::text('img',null,['class'=>'form-control','id'=>'UploadImage']) !!}
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

</div>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>
