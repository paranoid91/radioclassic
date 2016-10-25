<div class="row"  style="margin-bottom:15px;">
    <div class="col-sm-5">
        <div class="form-group">
            {!! Form::label('parent',trans('all.parent').' '.trans('all.category')) !!}
            {!! Form::selectCat('parent',$categories,null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            {!! Form::label('name',trans('all.name')) !!}
            {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Category Name']) !!}
            <i><small>({{trans('all.if_translate')}})</small></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            {!! Form::label('slug',trans('all.url').' ('.trans('all.auto_gen').')') !!}
            {!! Form::text('slug',null,['class'=>'form-control','placeholder'=>'Auto Generation']) !!}
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