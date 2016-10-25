<div class="col-sm-10">
    <div class="form-group">
       <span>
           <a class="btn btn-warning">{{$num + 1}}</a>
           <a class="btn btn-success iframe-btn" href="{{ asset('/filemanager/dialog.php?type=1&descending=false&akey=baa950b9ec364447b677a1fa7cda724b&field_id=UploadImage' . $image_id )}}"><i class="fa fa-image"></i> {{trans('all.chose_img')}}</a>
           <a class="btn btn-danger" onClick="removeImageMore(this)"><i class="fa fa-trash-o"></i> {{trans('all.remove')}}</a>
           <a class="image_details btn btn-info" data-toggle="modal" data-target="#ImageEditModal{{$image_id}}" ><i class="fa fa-edit"></i> {{trans('all.edit')}}</a>
       </span>
    </div>
</div>
