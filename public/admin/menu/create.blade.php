@extends('admin.app')

@section('content')
    <h2>{{ trans('articles.create') }}</h2>

    @include('admin.menu.form',['data'=>'','name'=>'','route'=>action('Admin\MenuBuilderController@store'),'method'=>'POST','item'=>[]])

    @stop