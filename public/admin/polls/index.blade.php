@extends('admin.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        {{ trans('polls.polls') }}
        <a href="{{ action('Admin\PollsController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
    </div>

    <div class="panel-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#ID</th><th>{{trans('all.title')}}</th><th>{{trans('all.status')}}</th><th>{{trans('polls.answers')}}{{trans('all.s')}} {{trans('all.count')}}</th><th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($polls as $poll)
            <tr>
                <td>{{ $poll->id }}</td>
                <td><a href="{{ action('Admin\PollsController@edit',$poll->id) }}" class="col-lg-11">{{ $poll->title }}</a></td>
                <td><a class="poll-status" data-route="{{ action('Admin\PollsController@active',$poll->id) }}" data-token="{{csrf_token()}}">{!! ($poll->status == 1) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</a></td>
                <td>{{ $poll->answers }}</td>
                <td>
                    <a href="{{ action('Admin\PollsController@edit',$poll->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\PollsController@destroy',$poll->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" align="center">{!! str_replace('/?', '?', $polls->render()) !!}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
@include('admin.modals.remove',['item'=>trans('polls.sure')])
@stop