@extends('admin.app')


@section('content')

<h2>{{ trans('pages.edit') }}</h2>
{{--*/ $date = date('d/m/Y H:i',strtotime($page->published_at)) /*--}}
{!! Form::model($page,['method'=>'PATCH', 'action'=>['Admin\PagesController@update',$page->id]] ) !!}
@include('admin.pages.form',['submitButtonText'=>trans('all.edit'),'lang'=>$page->lang])
{!! Form::close() !!}
@include("admin.preview_script")
@include('errors.list')

@stop