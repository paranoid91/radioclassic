<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('site_title',trans('all.site_title')) !!}
            {!! Form::text('site_title',get_value_by_name($settings,'site_title'),['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('site_tags',trans('all.site_tags')) !!}
            {!! Form::text('site_tags',get_value_by_name($settings,'site_tags'),['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('site_description',trans('all.site_description')) !!}
            {!! Form::textarea('site_description',get_value_by_name($settings,'site_description'),['class'=>'form-control']) !!}
        </div>
    </div>
</div>

{{--<div class="row">--}}
    {{--<div class="col-sm-4">--}}
        {{--<div class="form-group">--}}
            {{--<!--{!! Form::label('allow_registration',trans('all.users')) !!}-->--}}
            {{--<label for="allow_registration">{!! Form::checkbox('allow_registration',1,(get_value_by_name($settings,'allow_registration') == 0) ? 0 : 1) !!} {{trans('all.allow_registration')}}</label>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('slider_time',trans('admin.slide_time')) !!} (<small>{{trans('admin.seconds')}}</small>)
            {!! Form::input('number','slider_time',get_value_by_name($settings,'slider_time'),['class'=>'form-control','max'=>'30','style'=>'width:64px']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('banner_change_time',trans('admin.banner_change_time')) !!} (<small>{{trans('admin.seconds')}}</small>)
            {!! Form::input('number','banner_time',get_value_by_name($settings,'banner_time'),['class'=>'form-control','max'=>'30','style'=>'width:64px']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label('pagination_num',trans('all.pagination_num')) !!}
            {!! Form::input('number','pagination_num',get_value_by_name($settings,'pagination_num'),['class'=>'form-control','max'=>'30','style'=>'width:64px']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::submit(trans('all.save'),['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>