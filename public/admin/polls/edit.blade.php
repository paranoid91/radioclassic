@extends('admin.app')


@section('content')

<h2>{{ trans('polls.edit') }}</h2>

{{--*/ $date = date('d/m/Y H:i',strtotime($poll->published_at)) /*--}}
{!! Form::model($poll,['method'=>'PATCH', 'action'=>['Admin\PollsController@update',$poll->id]]) !!}
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('lang',trans('all.chose_language')) !!}
            {!! Form::select('lang',get_languages(),$poll->lang,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
@include('admin.polls.form',['submitButtonText'=>trans('all.save')])
{!! Form::close() !!}

@include('errors.list')

@stop