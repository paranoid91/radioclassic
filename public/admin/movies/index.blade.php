@extends('admin.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        {{ trans('movies.movies') }}
        <a href="{{ action('Admin\MoviesController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
    </div>

    <div class="panel-body">
        @include('admin.movies.filter')
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#ID</th><th>{{trans('all.title')}}</th><th>{{trans('all.category')}}</th><th>{{trans('all.author')}}</th><th>{{trans('all.published')}}</th><th>{{trans('all.status')}}</th><th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($movies as $movie)
            <tr>
                <td>{{ $movie->id }}</td>
                <td><a href="{{ action('Admin\MoviesController@edit',$movie->id) }}" class="col-lg-11" @if($movie->status==0)style="color:red;"@endif>{{ $movie->title }}</a></td>
                <td>{{--*/ $i=0 /*--}} @foreach($movie->categories as $cat) {{ $cat->name }} @if($i < (count($movie->categories) - 1)) , @endif {{--*/ $i++ /*--}} @endforeach</td>
                <td>
                    {{ $movie->author }}
                </td>
                <td>
                    {{ $movie->published_at }}
                </td>
                <td align="center"><a class="article-status" data-route="{{ action('Admin\MoviesController@active',$movie->id) }}" data-token="{{csrf_token()}}">{!! ($movie->status == 1) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</a></td>

                <td>
                    <a href="{{ action('Admin\MoviesController@edit',$movie->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\MoviesController@destroy',$movie->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>
            </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" align="center">{!! str_replace('/?', '?', $movies->render()) !!}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
@include('admin.modals.remove',['item'=>trans('movies.sure')])
@stop