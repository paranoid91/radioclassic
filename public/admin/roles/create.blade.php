@extends('admin.app')


@section('content')

<div class="panel panel-default">
    <div class="panel-heading">{{ trans('groups.add') }}</div>
    <div class="panel-body">
        {!! Form::open(['action'=>'Admin\RolesController@store']) !!}
        @include('admin.roles.form',['submitButtonText'=>trans('all.add')])
        {!! Form::close() !!}
    </div>
</div>
@include('errors.list')
</div>

@stop