@extends('admin.app')

@section('content')

    <h2>{{trans('all.edit')}}</h2>

    @include('admin.menu.form',['data'=>$item->value,'name'=>$item->name,'route'=>action('Admin\MenuBuilderController@update',$item->id),'method'=>'PUT'])
@stop