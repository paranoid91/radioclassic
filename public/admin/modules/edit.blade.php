@extends('admin.app')

@section('content')

    <h2>{{trans('all.edit_module')}}</h2>

    {!! Form::model($module,['action'=>['Admin\ModulesController@update',$module->id],'method'=>'PATCH']) !!}
    @include('admin.modules.form',['submitButtonText'=>trans('all.edit')])
    {!! Form::close() !!}

    @include('errors.list')
@stop