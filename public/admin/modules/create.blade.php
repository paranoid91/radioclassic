@extends('admin.app')

@section('content')

    <h2>{{trans('all.add_module')}}</h2>

    {!! Form::open(['action'=>'Admin\ModulesController@store','method'=>'post']) !!}
    @include('admin.modules.form',['submitButtonText'=>trans('all.add')])
    {!! Form::close() !!}

    @include('errors.list')
@stop