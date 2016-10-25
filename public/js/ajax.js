/**
 * Created by IT-Solutions on 6/7/15.
 */

var message = function(message,num){
    this.message = message;
    this.num = num;
    if(this.message.indexOf('permissions') > -1){
        $('#alert-messages').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+this.message+'</div>');
    }else{
        if(this.num){
            $('.table tbody tr:eq('+this.num+')').remove();
        }
        $('#alert-messages').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+this.message+'</div>');
    }

    $('div.alert').not('.alert-important').delay(3000).slideUp(200);
};


$('.remove-item').click(function(){
    var item = $(this);
    var token = item.attr('data-token');
    var route = item.attr('data-route');
    var num = item.attr('data-remove');

    $.ajax({
        url:route,
        type:'post',
        data:{_method:'DELETE',_token:token},
        success:function(msg){
            var result = new message(msg,num);
        }
    });
});




$('.ajax_author').on('keyup',function(){
    var token = $(this).data('token');
    var url = $(this).data('route');
    var text = $(this).val();
    if(text != "" && text.length > 1){
        $.ajax({
            url:url,
            type:'post',
            data:{_method:'POST',_token:token,text:text},
            success:function(request){
               if(request != 0){
                   $('.ajax_author_get').show().html(request);
                   $('.ajax_author_get ul li').click(function(){
                       $('.ajax_author_get').hide().html("");
                       $('.ajax_author').val($(this).text());
                   });
               }else{
                   $('.ajax_author_get').hide().html("");
               }

            }
        })
    }else{
        $('.ajax_author_get').hide().html("");
    }
});


$('.ajax_tags').on('keyup',function(){
    var token = $(this).data('token');
    var url = $(this).data('route');
    var text = $(this).val();


    if(text != "" && text.length > 1){
        var array = text.split(',');
        if(array[array.length-1].length > 1){
            $.ajax({
                url:url,
                type:'post',
                data:{_method:'POST',_token:token,text:array[array.length-1]},
                success:function(request){
                    if(request != 0){
                        $('.ajax_tags_get').show().html(request);
                        $('.ajax_tags_get ul li').click(function(){
                            $('.ajax_tags_get').hide().html("");
                            var name = $(this).data("name");
                            array.pop();
                            array.push(name);
                            $('.ajax_tags').val(array.join());
                        });
                    }else{
                        $('.ajax_tags_get').hide().html("");
                    }

                }
            })
        }

    }else{
        $('.ajax_tags_get').hide().html("");
    }
});




$('#sections tr td input[type="number"]').on('change',function(){
    var item = $(this);
    var token = item.attr('data-token');
    var value = $(this).val();
    var url = item.attr('data-url');
    $.ajax({
        url:url,
        type:'put',
        data:{_method:'PUT',_token:token,sort:value},
        success:function(msg){
            var result = new message(msg,false);
        }
    });
});


$(".poll-status").click(function(){
    var item = $(this);
    var token = item.attr('data-token');
    var route = item.attr('data-route');
    $.ajax({
        url:route,
        type:'put',
        data:{_method:'PUT',_token:token},
        success:function(msg){
            var result = new message(msg,false);

            if(msg.indexOf('deactivated') > -1){
                item.html('<i class="fa fa-times"></i>');
            }else{
                $(".poll-status").html('<i class="fa fa-times"></i>');
                item.html('<i class="fa fa-check"></i>');
            }
        }
    });
});


$(".article-status").click(function(){
    var item = $(this);
    var token = item.attr('data-token');
    var route = item.attr('data-route');
    $.ajax({
        url:route,
        type:'put',
        data:{_method:'PUT',_token:token},
        success:function(msg){
            var result = new message(msg,false);

            if(msg.indexOf('unpublished') > -1){
                item.html('<i class="fa fa-times"></i>');
                item.parent('td').parent('tr').find('td:nth-child(2)').find('a').css('color','red');
            }else{
                //$(this).html('<i class="fa fa-times"></i>');
                item.parent('td').parent('tr').find('td:nth-child(2)').find('a').css('color','#337AB7');
                item.html('<i class="fa fa-check"></i>');
            }
        }
    });
});


$( "#sortable" ).sortable().bind('sortupdate', function(e, ui) {
    var id = $('tbody#sortable tr').map(function(){
        return $(this).data("id");
    }).get();
    var url = $('tbody#sortable').data('route');
    var token = $('tbody#sortable').data('token');
    if(id.length > 0){
        $.ajax({
            url:url,
            type:'put',
            data:{_method:'PUT',_token:token,items:id}
        });
    }
});

$( "ul, li" ).disableSelection();

$("#main_cat").change(function(){
    $("#extra_parent_fields").html("");
    $("#extra_child_fields").html("");
    if($(this).val() > 0){
        var route = $("option:selected",this).data("route");
        var url = $("option:selected",this).data("url");
        var token = $("option:selected",this).data("token");
        var news_id = $("option:selected",this).data("news");
        var extra_fields = $("option:selected",this).data("extra");
        getCats($(this).val(),route,token,news_id);
        getFields($(this).val(),url,token,news_id,extra_fields);
        if($(this).val() == 66 || $(this).val() == 76){
            $('.main_cat_field').hide();
            $('.main_cat_'+$(this).val()).show();
        }else{
            $('.main_cat_field').hide();
        }
    }else{
        $(".rubrics").hide();
        $("#rubrics").html("");
        $("#extra_parent_fields").html("");
        $("#extra_child_fields").html("");
    }
});


$(document).ready(function(){
    if($("#main_cat").val() > 0){
        if($("#main_cat option:selected").val() > 0){
            if($("#main_cat option:selected").val() == 66 ||$("#main_cat option:selected").val() == 76){
                $('.main_cat_field').hide();
                $('.main_cat_'+$("#main_cat option:selected").val()).show();
            }
            var route = $("#main_cat option:selected").data("route");
            var url = $("#main_cat option:selected").data("url");
            var token = $("#main_cat option:selected").data("token");
            var news_id = $("#main_cat option:selected").data("news");
            var checked = $("#main_cat option:selected").data("checked");
            var extra_fields = $("#main_cat option:selected").data("extra");

            getCats($("#main_cat option:selected").val(),route,token,news_id,checked);
            getFields($("#main_cat option:selected").val(),url,token,news_id,extra_fields);
        }
    }

});

function getCats(id,route,token,news_id,checked){
    $.ajax({
        url:route,
        type:'POST',
        data:{_method:'post',_token:token,id:id,news_id:news_id,checked:checked},
        success:function(request){
            //console.log(request);
            if(request != ""){
                $("#rubrics").html(request);
                $(".rubrics").show();
            }else{
                $("#rubrics").html("");
                $(".rubrics").hide();
            }
        }
    });
}

function getFields(id,url,token,news_id,extra_fields,event){
    var unchecked = false;
    var parent = true;
    //console.log($(event).is(':checked'));
    if($(event).val() > 0){
        if(!$(event).is(':checked')){
            unchecked = true;
        }else{
            unchecked = false;
        }
        parent = false;
    }



    if(unchecked == false){
        $.ajax({
            url:url,
            type:'POST',
            data:{_method:'post',_token:token,id:id,news_id:news_id,extra_fields:extra_fields},
            beforeSend: function(){
                $("#preloader").html('<img src="/uploads/img/preloader.GIF" width="24"><br><br>');
            },
            success:function(request){
                if(request != "" && request != 1){
                    //console.log(request);
                    if(parent == true){
                        $("#extra_parent_fields").html(request);
                    }else{
                        $("#extra_child_fields").html(request);
                    }
                    $("#preloader").html("");

                }else{
                    $("#preloader").html("");
                }
            }
        });
    }else{
        $(".extra_fields_"+id).remove()
    }

}




$('.add_photo').click(function(){
    var imageLength = $('.image_buttons > div').length;
    var num = imageLength++;
    var url = $(this).data('url');
    var token = $(this).data('token');
    if(num > 1){
        $('input[name="type"]').val('photogallery');
    }
    if(num > 0){
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{_method:'POST',_token:token,image_id:num},
            success:function(request){
                //console.log(request.content);
                $('.image_buttons').append($("<div/>").html(request.content).text());
                $('.image_gallery').append('<li><span class="UploadImage'+num+'" data-id="'+(num+1)+'" data-toggle="modal" data-target="#ImageEditModal'+(num)+'"></span>'+$("<div/>").html(request.image).text()+'</li>');
                $('.iframe-btn').fancybox({
                    'width'		: 900,
                    'height'	: 600,
                    'type'		: 'iframe',
                    'autoScale'    	: false
                });
            }

        });
    }
});