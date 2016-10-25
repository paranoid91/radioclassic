@extends('admin.app')


@section('content')

    <h2>{{ trans('all.edit_entry') }}</h2>
    {{--*/ $date = date('d/m/Y H:i',strtotime($gallery->published_at)) /*--}}
    {!! Form::model($gallery,['method'=>'PATCH', 'action'=>['Admin\ImagesController@update',$gallery->id]]) !!}
    @include('admin.gallery.form',['submitButtonText'=>trans('all.edit'),'chose_author'=>$gallery->author,'lang'=>$gallery->lang])
    {!! Form::close() !!}

    @include('errors.list')

@stop