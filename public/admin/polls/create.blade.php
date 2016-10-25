@extends('admin.app')


@section('content')

    <h2>{{trans('polls.add')}}</h2>
    {{--*/ $date = date('d/m/Y H:i') /*--}}
    {!! Form::open(['action'=>'Admin\PollsController@store']) !!}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('lang',trans('all.chose_language')) !!}
                {!! Form::select('lang',get_languages(),null,['class'=>'form-control']) !!}
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
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
         {!! Form::label('title',trans('polls.title')) !!}
         {!! Form::text('title',null,['class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::submit(trans('all.add'),['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@include('errors.list')

@stop