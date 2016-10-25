@extends('admin.app')

@section('content')

<h2>{{trans('all.section_category_add')}}</h2>

{!! Form::open(['action'=>'Admin\CategoriesController@store']) !!}

@include('admin.categories.form',['submitButtonText'=>trans('all.add')])

{!! Form::close() !!}

@include('errors.list')

@stop