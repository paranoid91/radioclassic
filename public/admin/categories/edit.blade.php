@extends('admin.app')

@section('content')

<h2>{{trans('all.section_category_edit')}}</h2>

{!! Form::model($cat,['method'=>'PATCH', 'action'=>['Admin\CategoriesController@update',$cat->id]]) !!}

@include('admin.categories.form',['submitButtonText'=>trans('all.save')])

{!! Form::close() !!}

@include('errors.list')

@stop