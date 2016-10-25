@extends('admin.app')


@section('content')

    <h2>{{trans('movies.add')}}</h2>
    {{--*/ $date = date('d/m/Y H:i') /*--}}
    {!! Form::open(['action'=>'Admin\MoviesController@store']) !!}
         @include('admin.movies.form',['submitButtonText'=>trans('all.add'),'Movie'=>false,'checked'=>null,'selected'=>null,'chose_author'=>$auth,'lang'=>false])
    {!! Form::close() !!}

@include('errors.list')

@stop