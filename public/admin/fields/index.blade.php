@extends('admin.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            {{$cat->name}}
            <a id="add_field" class="btn btn-success right"><i class="fa fa-plus"></i> {{trans('all.add')}}</a><div class="fix"></div>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>trans</th><th>tag</th><th>type</th><th>value</th><th></th>
                </tr>
                </thead>
                <tbody>
                  @if(count($fields) > 0)
                      @foreach($fields as $field)
                       <tr id="old_field_{{$field->id}}">
                           <td><input type="text" name="trans" value="{{$field->trans}}" class="form-control" style="width:200px;position:relative;top:10px;"></td>
                           <td>
                               <select name="tag" data-id="{{$field->id}}" class="form-control" style="width:200px">
                                   <option value="">---</option>
                                   <option value="input" data-type="text,checkbox,radio,number,color,range" @if($field->tag == "input") selected @endif>input</option>
                                   <option value="select" data-type="option" @if($field->tag == "select") selected @endif>select</option>
                                   <option value="textarea" @if($field->tag == "textarea") selected @endif>textarea</option>
                               </select>
                           </td>
                           <td   id="field_options{{$field->id}}">
                               @if($field->tag != "textarea")
                               <select name="type" class="form-control" style="width:200px">
                                   <option value="">---</option>
                                   @if($field->tag == "input")
                                       <option value="text" @if($field->type=="text") selected @endif>text</option>
                                       <option value="checkbox" @if($field->type=="checkbox") selected @endif>checkbox</option>
                                       <option value="radio" @if($field->type=="radio") selected @endif>radio</option>
                                       <option value="number" @if($field->type=="number") selected @endif>number</option>
                                       <option value="color" @if($field->type=="color") selected @endif>color</option>
                                       <option value="range" @if($field->type=="range") selected @endif>range</option>
                                   @endif
                                   @if($field->tag == "select")
                                       <option value="option" @if($field->type=="option") selected @endif>option</option>
                                   @endif
                               </select>
                               @endif
                           </td>
                           <td   id="field_values{{$field->id}}">
                               @if($field->type=="radio" or $field->type=="option")
                                   <a class="btn btn-default add-options"  data-toggle="modal" data-target="#OptionsModalOld{{$field->id}}" style="position:relative;top:10px;">edit options</a>
                               @endif
                           </td>
                           <td><button class="btn btn-success save-options-old" data-id="{{$field->id}}" style="position:relative;top:10px;" data-token="{{csrf_token()}}"  data-route="{{ action('Admin\FieldsController@update',$field->id) }}"><i class="fa fa-save"></i> {{trans('all.save')}}</button></td>
                           <td><button class="btn btn-danger remove-field" data-token="{{csrf_token()}}" data-route="{{ action('Admin\FieldsController@drop',$field->id) }}" style="position:relative;top:10px;"><i class="fa fa-trash-o"></i> {{trans('all.del')}}</button></td>

                           @include('admin.modals.options',['id'=>$field->id,'values'=>$field->value])
                       </tr>
                       @endforeach
                  @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var field_num = 0;
            $('#add_field').on('click',function(){
                var modal = '<div id="OptionsModal'+field_num+'" class="modal fade" role="dialog"><div class="modal-dialog">'+
                            '<div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>'+
                            '<h4 class="modal-title">options</h4></div><div class="modal-body">' +
                            '</div><div class="modal-footer">'+
                            '<button class="btn btn-primary add_option_field" data-field="'+field_num+'"><i class="fa fa-plus"></i> {{trans('all.add_field')}}</button><button type="button" class="btn btn-success" data-remove="" data-dismiss="modal"><i class="fa fa-save"></i> {{trans('all.save')}}</button>'+
                            '<button type="button" class="btn btn-default remove_all_fields" data-field="'+field_num+'" data-dismiss="modal">{{trans('all.clean')}}</button></div></div></div></div>';

                var html = '<tr id="field_'+field_num+'"><td><input type="text" name="trans" value="" class="form-control" style="width:200px;position:relative;top:10px;"></td>'+
                '<td valign="top"><select name="tag" data-id="'+field_num+'" class="form-control" style="width:200px"><option value="">---</option>'+
                '<option value="input" data-type="text,checkbox,radio,number,color,range">input</option><option value="select" data-type="option">select</option>'+
                '<option value="textarea">textarea</option></select></td><td id="field_options'+field_num+'" style="width:210px;"></td><td id="field_values'+field_num+'" style="width:210px;">'+
                '<a class="btn btn-default add-options"  data-toggle="modal" data-target="#OptionsModal'+field_num+'" style="position:relative;top:10px;display:none;">add options</a>'+
                '</td><td><button class="btn btn-success save-options" data-id="'+field_num+'" style="position:relative;top:10px;" data-token="{{csrf_token()}}"  data-route="{{ action('Admin\FieldsController@store',$cat->id) }}"><i class="fa fa-save"></i> {{trans('all.save')}}</button></td>'+
                '<td><button onClick="$(this).parent(\'td\').parent(\'tr\').remove();" class="btn btn-danger" style="position:relative;top:10px;"><i class="fa fa-trash-o"></i> {{trans('all.del')}}</button></td>'+
                '</tr>';
                $('tfoot').append(html);
                $('body').append(modal);
                field_num++;
                $('select[name="tag"]').on('change',function(){
                    var data_id = $(this).data('id');
                    if($(':selected',this).data('type')){
                        var data = $(':selected',this).data('type').split(',');
                        var html = '<select name="type" class="form-control" style="width:200px"><option value="">---</option>';
                        for(var i=0; i<data.length;i++){
                            html += '<option value="'+data[i]+'">'+data[i]+'</option>';
                        }
                        html += '</select>';
                        $('#field_options'+data_id).html(html);
                        $('#field_options'+data_id+' select[name="type"]').on('change',function(){
                            if($(':selected',this).val() == 'option' || $(':selected',this).val() == 'radio' || $(':selected',this).val() == 'checkbox'){
                                $('#field_values'+data_id+' a').show();
                            }else{
                                $('#field_values'+data_id+' a').hide();
                            }
                        });


                    }else{
                        $('#field_options').html('');
                        $('#field_values'+data_id+' a').hide();
                    }
                });

                $('.add_option_field').on('click',function(){
                    var html = '<div><input type="text" name="value[trans][]" class="form-control trans" style="width:40%;display:inline-block;" value="" placeholder="trans"/> ' +
                               '<input type="text" name="value[val][]" value="" class="form-control val" style="width:40%;display:inline-block;" placeholder="option value"/> '+
                               '<button onClick="$(this).parent(\'div\').remove();" class="btn btn-danger" style="display:inline-block;"><i class="fa fa-trash-o"></i> {{trans('all.del')}}</button></div>';
                    var id = $(this).data('field');
                    $('#OptionsModal'+id+' .modal-body').append(html);
                });

                $('.remove_all_fields').on('click',function(){
                    var id = $(this).data('field');
                    $('#OptionsModal'+id+' .modal-body').html('');
                });



                $('.save-options').on('click',function(){
                    var id = $(this).data('id');
                    var route = $(this).data('route');
                    var token = $(this).data('token');
                    var input_trans = document.getElementById('OptionsModal'+id+'').getElementsByClassName('trans');
                    var input_val = document.getElementById('OptionsModal'+id+'').getElementsByClassName('val');
                    var error = false;
                    var value_fields = $('#OptionsModal'+id+' .modal-body div').length;
                    var fields = {
                        trans:$('#field_'+id+' input[name="trans"]').val(),
                        tag:$('#field_'+id+' select[name="tag"]').val(),
                        type:$('#field_'+id+' select[name="type"]').val()
                    };
                    var trans = [];
                    var val = [];
                    for(var i=0;i<value_fields;i++){
                        if(input_trans[i].value != "" && input_val[i].value != ""){
                            trans[i] = input_trans[i].value;
                            val[i] = input_val[i].value;
                        }
                    }




                    if(fields.trans == "" || fields.tag == ""){
                        error = true;
                    }

                     if(error == false){
                         $.ajax({
                              url:route,
                              type:'put',
                              data:{_method:'POST',_token:token,trans:fields.trans,tag:fields.tag,type:fields.type,field_trans:trans,val:val},
                              success:function(response){
                                  if(response != 12){
                                      var result = new message(response,false);
                                  }
                              }
                         });
                     }

                });
            });


            $('.add_option_field_old').on('click',function(){
                var html = '<div><input type="text" name="value[trans][]" class="form-control trans" style="width:40%;display:inline-block;" value="" placeholder="trans"/> ' +
                        '<input type="text" name="value[val][]" value="" class="form-control val" style="width:40%;display:inline-block;" placeholder="option value"/> '+
                        '<button onClick="$(this).parent(\'div\').remove();" class="btn btn-danger" style="display:inline-block;"><i class="fa fa-trash-o"></i> {{trans('all.del')}}</button></div>';
                var id = $(this).data('field');
                $('#OptionsModalOld'+id+' .modal-body').append(html);
            });

            $('.remove_all_fields_old').on('click',function(){
                var id = $(this).data('field');
                $('#OptionsModal'+id+' .modal-body').html('');
            });

            $('select[name="tag"]').on('change',function(){
                var data_id = $(this).data('id');
                if($(':selected',this).data('type')){
                    var data = $(':selected',this).data('type').split(',');
                    var html = '<select name="type" class="form-control" style="width:200px"><option value="">---</option>';
                    for(var i=0; i<data.length;i++){
                        html += '<option value="'+data[i]+'">'+data[i]+'</option>';
                    }
                    html += '</select>';

                    $('#field_options'+data_id).html(html);
                    $('#field_options'+data_id+' select[name="type"]').on('change',function(){
                        if($(':selected',this).val() == 'option' || $(':selected',this).val() == 'radio' || $(':selected',this).val() == 'checkbox'){
                            $('#field_values'+data_id+' a').show();
                        }else{
                            $('#field_values'+data_id+' a').hide();
                        }
                    });


                }else{
                    $('#field_options').html('');
                    $('#field_values'+data_id+' a').hide();
                }
            });


            $('.save-options-old').on('click',function(){
                var id = $(this).data('id');
                var route = $(this).data('route');
                var token = $(this).data('token');
                var input_trans = document.getElementById('OptionsModalOld'+id+'').getElementsByClassName('trans');
                var input_val = document.getElementById('OptionsModalOld'+id+'').getElementsByClassName('val');
                var error = false;
                var value_fields = $('#OptionsModalOld'+id+' .modal-body div').length;
                var fields = {
                    trans:$('#old_field_'+id+' input[name="trans"]').val(),
                    tag:$('#old_field_'+id+' select[name="tag"]').val(),
                    type:$('#old_field_'+id+' select[name="type"]').val()
                };
                var trans = [];
                var val = [];
                for(var i=0;i<value_fields;i++){
                    if(input_trans[i].value != "" && input_val[i].value != ""){
                        trans[i] = input_trans[i].value;
                        val[i] = input_val[i].value;
                    }
                }


                if(fields.trans == "" || fields.tag == ""){
                    error = true;
                }

                if(error == false){
                    $.ajax({
                        url:route,
                        type:'put',
                        data:{_method:'POST',_token:token,trans:fields.trans,tag:fields.tag,type:fields.type,field_trans:trans,val:val},
                        success:function(response){
                            if(response != 12){
                                var result = new message(response,false);
                            }
                        }
                    });
                }

            });

            $('.remove-field').on('click',function(){
                $(this).parent('td').parent('tr').remove();
                var route = $(this).data('route');
                var token = $(this).data('token');
                $.ajax({
                    url:route,
                    type:'put',
                    data:{_method:'PUT',_token:token},
                    success:function(response){
                        if(response != 12){
                            var result = new message(response,false);
                        }
                    }
                })
            });


        });


    </script>
@stop
