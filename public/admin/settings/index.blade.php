@extends('admin.app')


@section('content')
    {!! Form::model($settings,['method'=>'PATCH', 'action'=>['Admin\SettingsController@update']]) !!}
          @include("admin.settings.form")
    {!! Form::close() !!}
    @stop