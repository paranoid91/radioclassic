@extends('admin.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('all.billing') }}
            <a href="{{ action('Admin\BillingsController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
        </div>

        <div class="panel-body">
            @if(count($billings)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th><th>{{trans('all.short_desc')}}</th><th>{{trans('all.merchant_id')}}</th><th>{{trans('all.account_id')}}</th><th>{{trans('all.page_id')}}</th><th>{{trans('all.currency_code')}}</th><th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($billings as $billing)
                        <tr>
                            <td>{{ $billing->id }}</td>
                            <td><a href="{{ action('Admin\BillingsController@edit',$billing->id) }}">{{ $billing->short_desc }}</a></td>
                            <td>{{ $billing->merchant_id }}</td>
                            <td>{{ $billing->account_id }}</td>
                            <td>{{ $billing->page_id }}</td>
                            <td>{{ $billing->currency }}</td>
                            <td>
                                <a href="{{ action('Admin\BillingsController@edit',$billing->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\BillingsController@destroy',$billing->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" align="center">{!! str_replace('/?', '?', $billings->render()) !!}</td>
                    </tr>
                    </tfoot>
                </table>
            @else
                <div class="alert alert-info alert-important">
                    {{trans('all.no_records')}}
                </div>
            @endif
        </div>

        @include('admin.modals.remove',['item'=>trans('all.entry_sure')])
    </div>

@stop