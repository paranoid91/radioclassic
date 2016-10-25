@extends('admin.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        {{trans('all.users')}}
        <a href="{{ action('Admin\UsersController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
    </div>

    <div class="panel-body">

        <table class="table table-hover">
            <thead>
            <tr>
                <th>#ID</th><th>{{trans('all.username')}}</th><th>{{trans('all.email')}}</th><th>{{trans('all.group')}}</th><th>{{trans('all.registered_at')}}</th><th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td><a href="{{ action('Admin\UsersController@edit',$user->id) }}" class="col-lg-11">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles[0]->name }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <a href="{{ action('Admin\UsersController@edit',$user->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\UsersController@destroy',$user->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" align="center">{!! str_replace('/?', '?', $users->render()) !!}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
@include('admin.modals.remove',['item'=>trans('all.user_sure')])
@stop