@extends('admin.app')

@section('content')
    <h2>{{trans('all.new_entry')}}</h2>
    <div class="col-xs-5">
    {!! Form::open(['action'=>'Admin\BillingsController@store']) !!}
     @include('admin.billings.form',['submitButtonText'=>trans('all.add')])
    {!! Form::close() !!}
    </div>
    @include('errors.list')
@stop