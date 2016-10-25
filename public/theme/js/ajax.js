/**
 * Created by Vati Child on 11/11/2015.
 */

var songs = setInterval(function(){
    $.ajax({
        type: 'GET',
        url: '/get/xml/playlist',
        dataType: 'json',
        success: function (data) {
            var xmlNowTitle = data.now.title;
            var xmlNowComposer = data.now.composer;
            var xmlPrevComposer = data.previous.composer;
            var xmlPrevTitle = data.previous.title;
            var xmlNextComposer = data.next.composer;
            var xmlNextTitle = data.next.title;

            var pageNow = $('#musTitle').html();
            if(xmlNowTitle!=pageNow){
                $('.composer').html(xmlNowComposer);
                $('.mus-title').html(xmlNowTitle);

                $('.prevSong h3').html(xmlPrevComposer);
                $('.prevSong h5').html(xmlPrevTitle);
                $('.nowSong h3').html(xmlNowComposer);
                $('.nowSong h5').html(xmlNowTitle);
                $('.nextSong h3').html(xmlNextComposer);
                $('.nextSong h5').html(xmlNextTitle);
            }
        }
    });
}, 45000);



var loadRecords = function(e){
    var e = $(e);
    var num = 10;

    var records = $('.records .records-list .records-content ul li').length;
    //console.log(e.data('num')+'-'+records+'-'+e.data('cat'));
    if(e.data('url') != "" && e.data('token') != "" && e.data('cat') != ""){
        if(e.data('num') > 0 && e.data('num') != ""){
            num = e.data('num');
        }
        $.ajax({
            url:e.data('url'),
            type:'POST',
            data:{_method:'post',_token: e.data('token'),slug: e.data('cat'), num: num,records:records},
            beforeSend:function(){
                $('#preloader').html('<img src='+ e.data('preloader') +' />').css('text-align','center');
            },
            success:function(response){
                if(response != 0){
                    $('.records .records-list .records-content ul').append(response);
                }
                $('#preloader').html('');
                $('.records-content ul li.item-list').hover(
                    function(){
                        $('.item-desc',$(this)).slideDown(300);
                    },function(){
                        $('.item-desc',$(this)).slideUp(300);
                    }
                );
            }
        })
    }
};

/**
 * Send Competition data
 */

var sendCompetitionData = function(e){
    var e = $(e);
    var error = false;
    var questions = $('.competition-form .question').length;

    if(questions > 0){
        for(var i=1;i<=questions;i++){
            if($('input[name="question'+i+'"]:checked').val() > 0){
                error = false;
                $('input[name="question'+i+'"]').next('label').css('border','2px solid #707070');
                $('input[name="question'+i+'"]:checked').next('label').css('border','2px solid #e16426');
            }else{
                $('input[name="question'+i+'"]').next('label').css('border','2px solid red');
                error = true;
            }
        }
    }
    if($('input[name="first_name"]',e).val() == ""){
        $('input[name="first_name"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="first_name"]',e).css('border','2px solid green');
    }

    if($('input[name="last_name"]',e).val() == ""){
        $('input[name="last_name"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="last_name"]',e).css('border','2px solid green');
    }

    if($('input[name="age"]',e).val() == ""){
        $('input[name="age"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="age"]',e).css('border','2px solid green');
    }

    if($('input[name="address"]',e).val() == ""){
        $('input[name="address"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="address"]',e).css('border','2px solid green');
    }

    if($('input[name="zip_code"]',e).val() == ""){
        $('input[name="zip_code"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="zip_code"]',e).css('border','2px solid green');
    }

    if($('input[name="town"]',e).val() == ""){
        $('input[name="town"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="town"]',e).css('border','2px solid green');
    }

    if($('input[name="phone"]',e).val() == ""){
        $('input[name="phone"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="phone"]',e).css('border','2px solid green');
    }

    if($('input[name="email"]',e).val() == ""){
        $('input[name="email"]',e).css('border','2px solid red');
        error = true;
    }else{
        $('input[name="email"]',e).css('border','2px solid green');
    }

    if(error == false){
        return true;
    }else{
        return false;
    }

};

function getAjaxPlaylist(e){
    var e = $(e);
    if($("input[name='_token']",e).val() != ""){
        $.ajax({
            url:$("input[name='action']",e).val(),
            type:"POST",
            data:{_method:'post',_token:$("input[name='_token']",e).val(),date:$("input[name='date']",e).val()},
            success:function(response){
                console.log(response);
                if(response != ""){
                    $("#music-list").html(response);
                }
            }
        })
    }
}


//function ajaxRoute(url,hash){
//    $.ajax({
//        url:url,
//        type:'GET',
//        data:{_method:'get',_token:$("#token").text()},
//        beforeSend:function(){
//            var totalTime = new Date().getMilliseconds();
//            $("#load_screen").show();
//            $("#load_screen div").animate({width:'100%'},(totalTime * 3));
//        },
//        success:function(response){
//            $("#container").html(response);
//            history.pushState(1, url, hash);
//            $(window).scrollTop(0);
//            $("#load_screen div").css('width','100%');
//            $("#load_screen").fadeOut(100);
//            $("#load_screen div").animate({width:'0%'},10);
//        }
//    });
//}


function ajaxRoute(url,hash,cat){
    //console.log(url + ' - ' + window.location.href);
    clearInterval(songs);
    if(url == window.location.href && window.location.hash != ""){
        return false;
    }
    console.log(url);
    cat = (cat != '') ? cat : '';
    $.ajax({
        url: url,
        type:'GET',
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        data:{_method:'get',_token:$("#token").text()},
        beforeSend:function(){
            var totalTime = new Date().getMilliseconds();
            $("#load_screen").show();
            $("#load_screen div").animate({width:'100%'},(totalTime * 3));
        },
        success:function(response){
            $('<div>',{html:response}).find('.site_container').each(function(){
                $(".site_container").html($(this).html());
                //FB.XFBML.parse();
            });
            //var stateObj = { foo: hash};
            history.pushState(1, url, url);
            window.onpopstate = function (evt) {
                /** event.state contains the stored JS object, so we can pass it back **/
                ajaxRoute(window.location.href,window.location.pathname,1);
            };
            $(window).scrollTop(0);
            $("#load_screen div").css('width','100%');
            $("#load_screen").fadeOut(100);
            $("#load_screen div").animate({width:'0%'},10);
            if(url == "http://radioclassic.fi"){

                twttr.widgets.load();

                var feed = new Instafeed({
                    get: 'user',
                    userId: 1302796146,
                    clientId: '1b4f9eb4808147b8931e66529b5e28b1',
                    accessToken: '1302796146.1677ed0.5ff4813d10eb46a5a8036e2cbc5693a1',
                    limit: 6
                });
                feed.run();
            }

            FB.XFBML.parse();
        },complete:function(){
            var meta_tags = $("#meta").text();
            var json = JSON.parse(meta_tags);
            $.each(json,function(k,v){
                if(k == 'title'){
                    document.title = v;
                }
                if(k=='site_name' || k=='title' || k=='image' || k=='url' || k=='type'){
                    $('meta[property="og:'+k+'"]').attr('content', v);
                    if(k=='image'){
                        $('meta[name="thumbnail"]').attr('content', v);
                    }
                }
                if(k=='description' || k=='pubdate'){
                    $('meta[property="og:'+k+'"]').attr('content', v);
                    $('meta[name="'+k+'"]').attr('content', v);
                }
                if(k=='keyword' || k=='section' || k=='author' || k=='lastmod'){
                    $('meta[name="'+k+'"]').attr('content', v);
                }

            });
        }

    });
    return false;
}



function searchAjax(e){
    var e = $(e);
    if($('input[name="search"]',e).val() != "" && $('input[name="search"]',e).val() != "undefined"){
        ajaxRoute('/search/'+$('input[name="search"]',e).val(),'/search/'+$('input[name="search"]',e).val());
    }
}