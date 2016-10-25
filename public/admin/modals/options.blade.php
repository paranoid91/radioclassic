
<!-- Modal -->
<div id="OptionsModalOld{{$id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {{--*/ $values = unserialize($values) /*--}}

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">options</h4>
            </div>
            <div class="modal-body">
                @if(count($values) > 0)
                    @for($i=0;$i<count($values['trans']);$i++)
                        <div>
                            <input type="text" name="value[trans][]" value="{{$values['trans'][$i]}}" class="form-control trans" style="width:40%;display:inline-block;" value="" placeholder="trans"/>
                            <input type="text" name="value[val][]" value="{{$values['trans'][$i]}}" class="form-control val" style="width:40%;display:inline-block;" placeholder="option value"/>
                            <button onClick="$(this).parent('div').remove();" class="btn btn-danger" style="display:inline-block;"><i class="fa fa-trash-o"></i> {{trans('all.del')}}</button>
                        </div>
                    @endfor
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary add_option_field_old" data-field="{{$id}}"><i class="fa fa-plus"></i> {{trans('all.add_field')}}</button>
                <button type="button" class="btn btn-success" data-remove="" data-dismiss="modal"><i class="fa fa-save"></i> {{trans('all.save')}}</button>
                <button type="button" class="btn btn-default remove_all_fields_old" data-field="{{$id}}" data-dismiss="modal">{{trans('all.close')}}</button>
            </div>
        </div>

    </div>
</div>