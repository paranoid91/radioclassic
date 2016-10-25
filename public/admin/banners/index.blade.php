@extends('admin.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('banners.banners') }}
            <a href="{{ action('Admin\BannersController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
        </div>
        <div class="panel-body">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>{{trans('all.status')}}</th>
                    <th>{{trans('all.position')}}</th>
                    <th>{{trans('all.name')}}</th>
                    <th>{{trans('all.size')}}</th>
                    <th>{{trans('all.published_at')}}</th>
                    <th>{{trans('all.finished_at')}}</th><th></th>
                </tr>
                </thead>
                <tbody>

                {{--@foreach($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td><a href="{{ action('Admin\BannersController@edit',$banner->id) }}" class="col-lg-11">{{ $banner->title }}</a></td>
                        <td>{{  ($banner->size_x > 0) ? $banner->size_x : 'auto' }} X {{($banner->size_y > 0) ? $banner->size_y : 'auto'}}</td>
                        <td>{{ $banner->published_at }}</td>
                        <td>{{ $banner->finished_at }}</td>
                        <td>
                            <a href="{{ action('Admin\BannersController@edit',$banner->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\BannersController@destroy',$banner->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach--}}

                @foreach($banners_new as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td> @if(strtotime($banner->finished_at) > time()) Active @else Out of date @endif</td>
                        <td>{{$banner->categories[0]->name}}</td>
                        <td><a href="{{ action('Admin\BannersController@edit',$banner->id) }}" class="col-lg-11">{{ $banner->title }}</a></td>
                        <td>{{  ($banner->size_x > 0) ? $banner->size_x : 'auto' }} X {{($banner->size_y > 0) ? $banner->size_y : 'auto'}}</td>
                        <td>{{ $banner->published_at }}</td>
                        <td>{{ $banner->finished_at }}</td>
                        <td>
                            <a href="{{ action('Admin\BannersController@edit',$banner->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\BannersController@destroy',$banner->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6" align="center">{!! str_replace('/?', '?', $banners->render()) !!}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @include('admin.modals.remove',['item'=>trans('banners.sure')])
@stop