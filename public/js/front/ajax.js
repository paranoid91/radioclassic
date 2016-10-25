/**
 * Created by it-solutions on 7/16/2015.
 */

function vote(e){
    if($(e).find('input:checked').val() > 0){
        $.ajax({
            url:$(e).data('route'),
            type:'PUT',
            data:{_method:'PUT',_token:$(e).data('token'),parent_id:$(e).data('id'),id:$(e).find('input:checked').val()},
            success:function(data){
                if(data == 'success'){
                     $('.poll-unv').addClass('vote-hide').removeClass('vote-show');
                     $('.poll-voted').addClass('vote-show').removeClass('vote-hide');
                }
            }
        });
    }
}