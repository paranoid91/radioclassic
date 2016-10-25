<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('title',trans('all.title')) !!}
            {!! Form::input('text','title',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('name',trans('all.name')) !!}
            {!! Form::input('text','name',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('controller',trans('all.controller')) !!}
            {!! Form::input('text','controller',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('trans',trans('all.trans')) !!}
            {!! Form::input('text','trans',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('icon',trans('all.icon_class')) !!}
            {!! Form::input('text','icon',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>