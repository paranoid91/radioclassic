@extends('admin.app')

@section('content') {{-- master @yield(content)--}}

<div class="panel panel-default">
    <div class="panel-heading">
        {{ trans('admin.slider') }}
        <a href="{{ action('Admin\SliderController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('admin.add')}}</a><div class="fix"></div>
    </div>
    <div class="panel-body">
        @if(count($sliders) > 0)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>{{trans('admin.img')}}</th>
                    <th>{{trans('admin.title')}}</th>
                    <th>{{trans('admin.created_at')}}</th>
                    <th>{{trans('admin.status')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($sliders as $slider)
                    <tr>
                        <td>{{$slider->id}}</td>
                        <td>
                            <img src="{{str_replace('/all/','/thumbs/',$slider->poster)}}" width="100px">
                        </td>
                        <td><a href="{{ action('Admin\SliderController@edit',$slider->id) }}" class="col-lg-11">{{$slider->title}}</a></td>
                        <td>{{$slider->created_at}}</td>
                        <td>
                            <i class="{{($slider->is_publish > 0) ? 'fa fa-check':'fa fa-close'}}" style="color:{{($slider->is_publish > 0) ? 'green':'red'}};"></i>
                        </td>
                        <td>
                            <a href="{{ action('Admin\SliderController@edit',$slider->id) }}" class="btn btn-info"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            <a class="remove-modal btn btn-danger" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\SliderController@destroy',$slider->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6" align="center">{!! str_replace('/?', '?', $sliders->render()) !!}</td>
                </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>

@include('admin.modals.remove',['item'=>trans('admin.sure')])

@stop