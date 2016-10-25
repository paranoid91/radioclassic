@extends('admin.app')

@section('content')
    <h2>{{trans('all.edit_entry')}}</h2>
    <div class="col-xs-5">
    {!! Form::model($billing,['action'=>['Admin\BillingsController@update',$billing->id],'method'=>'PATCH']) !!}
    @include('admin.billings.form',['submitButtonText'=>trans('all.edit')])
    {!! Form::close() !!}
    </div>
    <div class="col-xs-6 billing-info">
        <div class="row">
            <div class="col-sm-15">
                   <b>{{trans('all.check_url')}}</b>: {{action('Admin\BillingsController@check',$billing->id)}}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-15">
                <b>{{trans('all.register_url')}}</b> : {{action('Admin\BillingsController@pay',$billing->id)}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-15 last">
                <b>{{trans('all.payment_button_url')}}</b> : <br><span>{{$billing->url}}?merch_id={{$billing->merchant_id}}&page_id={{$billing->page_id}}&back_url_s={{$billing->back_url_s}}&back_url_f={{$billing->back_url_f}}&o.amount={amount}&o.uid={user_id}</span>
            </div>
        </div>
    </div>

    @include('errors.list')
@stop