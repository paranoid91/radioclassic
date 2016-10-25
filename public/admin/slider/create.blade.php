@extends('admin.app')

@section('content')
    <h3>{{trans('admin.add_slider_item')}}</h3>
    <hr>
        <!-- AJAX REQUEST MESSAGE PLACE -->
<div class="message_place"></div>

{!! Form::open(['method'=>'POST','action'=>'Admin\SliderController@store']) !!}

@include('admin.slider.form')

{!! Form::close() !!}

        <!-- AJAX REQUEST MESSAGE PLACE -->
<div class="message_place"></div>
@include('errors.list')
@stop