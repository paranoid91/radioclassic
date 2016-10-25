@extends('admin.app')


@section('content')

    <h2>{{trans('all.new_entry')}}</h2>
    {{--*/ $date = date('d/m/Y H:i') /*--}}
    {!! Form::open(['action'=>'Admin\ImagesController@store']) !!}
    @include('admin.gallery.form',[
    'submitButtonText'=>trans('all.add'),
    'images'=>null,
    'chose_author'=>$auth,
    'lang'=>App::getLocale()
    ])
    {!! Form::close() !!}

    @include('errors.list')

@stop