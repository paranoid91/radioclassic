@extends('admin.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{ trans('images.gallery') }}
        <a href="{{ action('Admin\ImagesController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{ trans('all.add') }}</a><div class="fix"></div>
    </div>

    <div class="panel-body">
        @include('admin.gallery.filter')
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#ID</th><th>{{ trans('all.title') }}</th><th>{{ trans('all.author') }}</th><th>{{ trans('all.images').trans('all.s').' '.trans('all.count') }}</th><th>{{trans('all.published')}}</th><th>{{trans('all.status')}}</th><th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($gallery as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ action('Admin\ImagesController@edit',$item->id) }}" class="col-lg-11" @if($item->status==0)style="color:red;"@endif>{{ $item->title }}</a></td>
                    <td>{{ $item->author }}</td>
                    <td>{{ count(unserialize($item->images)) }}</td>
                    <td>{{ $item->published_at }}</td>
                    <td align="center"><a class="article-status" data-route="{{ action('Admin\ImagesController@active',$item->id) }}" data-token="{{csrf_token()}}">{!! ($item->status == 1) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</a></td>
                    <td>
                        <a href="{{ action('Admin\ImagesController@edit',$item->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\ImagesController@destroy',$item->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" align="center">{!! str_replace('/?', '?', $gallery->render()) !!}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

@include('admin.modals.remove',['item'=>trans('images.sure')])
@stop