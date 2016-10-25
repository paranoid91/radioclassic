@extends('admin.app')


@section('content')

<h2>{{ trans('movies.edit') }}</h2>
{{--*/ $date = date('d/m/Y H:i',strtotime($movie->published_at)) /*--}}
{!! Form::model($movie,['method'=>'PATCH', 'action'=>['Admin\MoviesController@update',$movie->id]]) !!}

@include('admin.movies.form',['submitButtonText'=>trans('all.edit'),'selected'=>$movie->categories[0]->pivot->cat_id,'chose_author'=>$movie->author,'lang'=>$movie->lang])
{!! Form::close() !!}

@include('errors.list')

@stop