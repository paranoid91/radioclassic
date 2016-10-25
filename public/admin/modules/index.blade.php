@extends('admin.app')

@section('content')

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('all.modules') }}
                <a href="{{ action('Admin\ModulesController@create') }}" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
            </div>

            <div class="panel-body">
                @if(count($modules)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#ID</th><th>{{trans('all.title')}}</th><th>{{trans('all.name')}}</th><th>{{trans('all.controller')}}</th><th>{{trans('all.status')}}</th><th></th>
                    </tr>
                    </thead>
                    <tbody id="sortable"  data-route="{{action('Admin\ModulesController@sort',1)}}" data-token="{{csrf_token()}}">

                    @foreach($modules as $module)
                        <tr class="ui-state-default" data-id="{{$module->id}}">
                            <td>{{ $module->id }}</td>
                            <td><a href="{{ action('Admin\ModulesController@edit',$module->id) }}" class="col-lg-11" @if($module->status==0)style="color:red;"@endif>{{ $module->title }}</a></td>
                            <td>{{ $module->name }}</td>
                            <td>{{ $module->controller }}</td>
                            <td align="left"><a class="article-status" data-route="{{ action('Admin\ModulesController@active',$module->id) }}" data-token="{{csrf_token()}}">{!! ($module->status == 1) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</a></td>
                            <td>
                                <a href="{{ action('Admin\ModulesController@edit',$module->id) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                <a class="remove-modal" data-toggle="modal" data-target="#RemoveModal" data-url="{{ action('Admin\ModulesController@destroy',$module->id) }}" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" align="center">{!! str_replace('/?', '?', $modules->render()) !!}</td>
                    </tr>
                    </tfoot>
                </table>
                @else
                    <div class="alert alert-info alert-important">
                        {{trans('all.no_records')}}
                    </div>
                @endif
            </div>

            @include('admin.modals.remove',['item'=>trans('all.module_alert')])
        </div>

@stop