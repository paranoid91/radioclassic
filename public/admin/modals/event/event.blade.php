<!-- Modal -->
<div id="EventModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Event</h4>
            </div>
            <div class="modal-body">
                @include('admin.events.form')
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onClick="$('#save_event').click();"><i class="fa fa-save"></i> {{trans('all.save')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('all.close')}}</button>
            </div>
        </div>

    </div>
</div>