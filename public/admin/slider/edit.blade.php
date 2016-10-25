@extends('admin.app')

@section('content')
    <h3>{{trans('admin.edit_slider_item')}} : {{$slider->id}}</h3>
    <hr>
    <!-- AJAX REQUEST MESSAGE PLACE -->
    <div class="message_place"></div>
    {!! Form::model($slider,['method'=>'PATCH','action'=>['Admin\SliderController@update',$slider]]) !!}
    @include('admin.slider.form')
    {!! Form::close() !!}
            <!-- AJAX REQUEST MESSAGE PLACE -->
    <div class="message_place"></div>
    @include('errors.list')
@stop