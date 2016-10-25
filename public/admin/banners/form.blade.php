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
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('finished_at',trans('all.finished_at')) !!}
            {!! Form::text('finished_at',$date2,['class'=>'form-control','id'=>'datetimepicker2']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('cat',trans('all.position')) !!}
            {!! Form::select('cat',$cats,$selected,['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('title',trans('all.title')) !!}
            {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('slug',trans('all.url').' ('.trans('all.auto_gen').')') !!}
            {!! Form::text('url',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-1">
        <div class="form-group">
            {!! Form::label('size_x', trans('all.size').' X') !!}
            {!! Form::text('size_x',null,['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            {!! Form::label('size_y',trans('all.size').' Y') !!}
            {!! Form::text('size_y',null,['class'=>'form-control']) !!}
        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <a class="btn btn-warning iframe-btn" href="{{ asset('/filemanager/dialog.php?type=2&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=UploadBanner') }}">{{trans('banners.chose')}}</a><br><br>
            {!! Form::label('banner',trans('banners.banner')) !!}{!! Form::text('banner',null,['class'=>'form-control','id'=>'UploadBanner']) !!}
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