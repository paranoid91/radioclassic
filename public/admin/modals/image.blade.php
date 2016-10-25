

<!-- Modal -->
<div id="ImageEditModal{{$num}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('all.edit_image')}}</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('image',trans('all.image_path')) !!} {!! Form::text('image['.$num.'][img]',$image_gallery[$num]['img'],['class'=>'form-control','id'=>'UploadImage'.$num]) !!}
                {!! Form::label('image',trans('all.title')) !!} {!! Form::text('image['.$num.'][title]',((!empty($image_gallery[$num]['title'])) ? $image_gallery[$num]['title'] : '' ),['class'=>'form-control']) !!}
                {!! Form::label('image',trans('all.alt_text')) !!} {!! Form::text('image['.$num.'][alt]',((!empty($image_gallery[$num]['alt'])) ? $image_gallery[$num]['alt'] : '' ),['class'=>'form-control']) !!}
                {!! Form::label('image',trans('all.photo_source')) !!} {!! Form::text('image['.$num.'][source]',((!empty($image_gallery[$num]['source'])) ? $image_gallery[$num]['source'] : '' ),['class'=>'form-control']) !!}
                {!! Form::label('image',trans('all.author')) !!} {!! Form::text('image['.$num.'][author]',((!empty($image_gallery[$num]['author'])) ? $image_gallery[$num]['author'] : '' ),['class'=>'form-control']) !!}
                {!! Form::label('image',trans('all.caption')) !!} {!! Form::text('image['.$num.'][meta_desc]',((!empty($image_gallery[$num]['meta_desc'])) ? $image_gallery[$num]['meta_desc'] : '' ),['class'=>'form-control']) !!}
                {!! Form::label('image',trans('all.meta_key')) !!} {!! Form::text('image['.$num.'][meta_key]',((!empty($image_gallery[$num]['meta_key'])) ? $image_gallery[$num]['meta_key'] : '' ),['class'=>'form-control']) !!}
                {!! Form::hidden('image['.$num.'][status]',0,['class'=>'form-control']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('all.close')}}</button>
            </div>
        </div>
    </div>
</div>