
<!-- Modal -->
<div id="RemoveModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('all.del_entry')}}</h4>
            </div>
            <div class="modal-body">
                <p>{{$item}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger remove-item" data-remove="" data-dismiss="modal" data-route=""  data-token="{{ csrf_token() }}">{{trans('all.del')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('all.close')}}</button>
            </div>
        </div>

    </div>
</div>