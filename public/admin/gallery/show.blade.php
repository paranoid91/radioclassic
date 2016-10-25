@extends('app')

@section('content')
    <h3>{{$gallery->title}}</h3>
    <p>
        {!! $gallery->body !!}
    </p>
@stop