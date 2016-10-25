@extends('admin.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        {{ trans('pages.pages') }}
        <a href="{{ action('Admin\PagesController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
    </div>

    <div class="panel-body">

        <table class="table table-hover">
            <thead>
            <tr>
                <th>#ID</th><th>{{trans('all.title')}}</th><th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($pages as $page)
            <tr>
                <td>{{ $page->id }}</td>
                <td><a href="{{ action('Admin\PagesController@edit',$page->id) }}" class="col-lg-11">{{ $page->title }}</a></td>
                <td>
                    <a href="{{ action('Admin\PagesController@edit',$page->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\PagesController@destroy',$page->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" align="center">{!! str_replace('/?', '?', $pages->render()) !!}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
@include('admin.modals.remove',['item'=>trans('pages.sure')])
@stop