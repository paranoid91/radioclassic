@extends('admin.app')

@section('content')

<h2>{{trans('all.edit_account')}}</h2>

{!! Form::model($user,['method'=>'PATCH', 'action'=>['Admin\UsersController@update',$user->id]]) !!}

@include('admin.users.form',['submitButtonText'=>trans('all.save'),'selected_role'=>$user->roles[0]->id])

{!! Form::close() !!}

@include('errors.list')

@stop