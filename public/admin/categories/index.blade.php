@extends('admin.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        {{trans('all.sections')}}
        <a href="{{ action('Admin\CategoriesController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
    </div>

    <div class="panel-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#ID</th><th>{{trans('all.title')}}</th><th>{{trans('all.url')}}</th><th>{{trans('all.sort')}}</th><th></th>
            </tr>
            </thead>
            <tbody id="sections">
            {{ parseAndPrintTree($categories) }}
            </tbody>
        </table>
    </div>
</div>
@include('admin.modals.remove',['item'=>trans('all.sec_sure')])


@stop