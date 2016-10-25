@extends('admin.app')


@section('content')

    <h2>{{ trans('banners.edit') }}</h2>
    {{--*/ $date = date('d/m/Y H:i',strtotime($banner->published_at)) /*--}}
    {{--*/ $date2 = date('d/m/Y H:i',strtotime($banner->finished_at)) /*--}}
    {!! Form::model($banner,['method'=>'PATCH', 'action'=>['Admin\BannersController@update',$banner->id]]) !!}
    @include('admin.banners.form',['submitButtonText'=>trans('all.save'),'lang'=>$banner->lang])
    {!! Form::close() !!}
    <hr>
    <object data="{{ $banner->banner }}" width="{{($banner->size_x > 0) ? $banner->size_x : '100%'}}" height="{{($banner->size_y > 0) ? $banner->size_y : '100%'}}" type="application/x-shockwave-flash" ><param name="wmode" value="opaque" /></object>

    @include('errors.list')

@stop