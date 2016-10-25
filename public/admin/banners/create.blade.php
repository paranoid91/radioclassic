@extends('admin.app')


@section('content')

    <h2>{{trans('banners.add')}}</h2>

    {{--*/ $date = date('d/m/Y H:i') /*--}}
    {{--*/ $date2 = date('d/m/Y H:i') /*--}}
    {!! Form::open(['action'=>'Admin\BannersController@store']) !!}
    @include('admin.banners.form',['submitButtonText'=>trans('all.add'),'selected'=>null,'lang'=>false])
    {!! Form::close() !!}

    @include('errors.list')

@stop