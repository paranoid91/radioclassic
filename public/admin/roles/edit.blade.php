@extends('admin.app')


@section('content')

        <div class="panel panel-default">
            <div class="panel-heading">{{trans('all.edit')}}</div>
            <div class="panel-body">
                {!! Form::model($role,['method'=>'PATCH', 'action'=>['Admin\RolesController@update',$role->id]]) !!}
                @include('admin.roles.form',['submitButtonText'=>trans('groups.edit')])
                {!! Form::close() !!}
            </div>
        </div>
        @include('errors.list')

@stop