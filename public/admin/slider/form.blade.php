<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            {!! Form::label('is_publish',trans('admin.enable')) !!}
            {!! Form::checkbox('is_publish',1,null,['onClick'=>'return ($(".status").val() == 1) ? $(".status").val(0) : $(".status").val(1);']) !!}
            {!! Form::hidden('is_publish',null,['class'=>'status']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            {!! Form::label('title',trans('admin.title')) !!} <i class="required">*</i>
            {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            {!! Form::label('sub_title',trans('admin.sub_title')) !!}
            {!! Form::text('sub_title',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            {!! Form::label('link',trans('admin.slider_link')) !!}
            {!! Form::text('link',null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            <div class="slider_image" data-no="true">
                <div>
                    @if(Form::getValueAttribute('poster') <> '')
                        <img src="{!! Form::getValueAttribute('poster') !!}" width="100%"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            {!! Form::text('poster',null,['class'=>'form-control','id'=>'slider_image','data-width'=>trans('admin.image_width_error'),'data-height'=>trans('admin.image_height_error')]) !!}
        </div>
        <div class="col-sm-4">
            <a href="{{asset('filemanager/dialog.php?type=1&descending=false&field_id=slider_image')}}" class="iframe-btn btn btn-primary" onClick="getFieldValue('slider_image','{{asset('/')}}',100,1024,600);" ><i class="fa fa-image"></i> Select Image *</a>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            {!! Form::submit(trans('admin.submit'),['class'=>'btn btn-success']) !!}
        </div>
    </div>
</div>