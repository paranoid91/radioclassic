{{--*/ $children = get_cat_by_parent(71) /*--}}
{!! Form::hidden('published_at',$date) !!}
{!! Form::hidden('status',1) !!}
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('lang',trans('all.chose_language')) !!}
            {!! Form::select('lang',get_languages(),$lang,['class'=>'form-control','style'=>'margin-top:0;']) !!}
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
