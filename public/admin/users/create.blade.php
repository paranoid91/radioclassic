@extends('admin.app')

@section('content')

<h2>{{trans('all.add_account')}}</h2>

{!! Form::open(['action'=>'Admin\UsersController@store']) !!}

@include('admin.users.form',['submitButtonText'=>trans('all.add'),'selected_role'=>null])

{!! Form::close() !!}

@include('errors.list')

@stop