@extends('admin.app')


@section('content')

    <h2>{{trans('articles.create')}}</h2>

    {{--*/ $date = date('d/m/Y H:i') /*--}}
    {{--*/ $finished_at = date('d/m/Y H:i') /*--}}
    {!! Form::open(['action'=>'Admin\ArticlesController@store']) !!}
         @include('admin.articles.form',[
         'submitButtonText'=>trans('all.add'),
         'item'=>false,'checked'=>null,
         'chose_author'=>$auth,
         'news_id'=>0,
         'parent'=>'',
         'brightcove'=>'',
         'embed'=>'',
         'lang'=>App::getLocale(),
         'type'=>''
         ])
    {!! Form::close() !!}
   @include("admin.preview_script")
@include('errors.list')

@stop