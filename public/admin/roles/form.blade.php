<div class="form-group">
    {!! Form::label('name',trans('admin.group_name')) !!}
    {!! Form::text('name',null,['class'=>'form-control']) !!}
</div>
<div class="table-responsive">

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.view') }}</th>
            <th>{{ trans('admin.add') }}</th>
            <th>{{ trans('admin.edit') }}</th>
            <th>{{ trans('admin.delete') }}</th>
            <th>{{ trans('admin.translate') }}</th>
            <th>{{ trans('admin.ajax') }}</th>
            <th>{{ trans('admin.publish') }}</th>
            <th>{{ trans('admin.only_my') }}</th>
        </tr>
        </thead>
        <tbody>

        @if(!empty($modules))
            @foreach($modules as $module)
                @if($role != false)
                    <?php $var = unserialize($role->permissions);?>
                @endif
                @if($module == 'translations')
                    <?php $display = 'display:none;';?>
                @else
                    <?php $display = '';?>
                @endif

                <tr>
                    <th>{{ trans('admin.'.$module) }}</th>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][index]','index',(!empty($var[$module]['index'])) ? $var[$module]['index'] : false) !!}
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][create]','create',(!empty($var[$module]['create'])) ? $var[$module]['create'] : false,['style'=>$display]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][edit]','edit',(!empty($var[$module]['edit'])) ? $var[$module]['edit'] : false,['style'=>$display]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][destroy]','destroy',(!empty($var[$module]['destroy'])) ? $var[$module]['destroy'] : false,['style'=>$display]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][translate]','destroy',(!empty($var[$module]['translate'])) ? $var[$module]['translate'] : false,['style'=>$display]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][ajax]','ajax',(!empty($var[$module]['ajax'])) ? $var[$module]['ajax'] : false,['style'=>$display]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][active]','active',(!empty($var[$module]['active'])) ? $var[$module]['active'] : false,['style'=>$display]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::checkbox('permissions['.$module.'][only_my]','only_my',(!empty($var[$module]['only_my'])) ? $var[$module]['only_my'] : false,['style'=>$display]) !!}
                        </div>
                    </td>

                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    {!! Form::submit($submitButtonText,['class' => 'btn btn-primary']) !!}
</div>