/**
 * Created by Vati Child on 11/11/2015.
 */

    // search placeholder
var inputPlaceholder = function(e,name){
    if($(e).val() == name){
        $(e).val("");
    }
};

// header navigation dropdown
$('.header-navigation > ul > li').hover(
    function(){
        $(this).find('ul').slideDown(300);
        var arrow_left =$(this).width() - 15;
        $(this).find('ul').find('.arrow').css('left',arrow_left+'px');
    },
    function(){
        $(this).find('ul').slideUp(300);
    }
);

//Radio player playlist
var onLoadWidth = $('.radio-player-playlist ul li.active .desc').width() + 132;
$('.radio-player-playlist ul li.active').css('width',onLoadWidth+'px');
$(".radio-player-playlist ul li.accordion").hover(
    function(){
        $('.radio-player-playlist ul li.active').animate({width: "120px"}, { queue:false, duration:400});
        var openWidth =  $('.desc',this).width() + 132;
        $(this).animate({width:openWidth +'px'}, { queue:false, duration:400});
        $('.radio-player-playlist ul li.active').removeClass('active');
        $(this).addClass('active');
    }
);


//Show frequencies

$('.radio-player-playlist .frequencies').hover(
    function(){
        $('.radio-stations').slideDown(300);
    },function(){
        $('.radio-stations').slideUp(300);
    }
);

//First view height set

//$('.first-view').css({height: window.innerHeight + 'px'});


//go down arrow
$('.go_down div i').click(function(){
    $(this).parent('div').parent('div').fadeOut(200);
    $('html,body').animate({
        scrollTop: $('.content').offset().top
    }, 500);
});



//scroll arrow
if($(window).scrollTop() > 10){
    $('.go_down').fadeOut(200);
}

$(window).scroll(function(){
    if($(this).scrollTop() > 10){
        $('.go_down').fadeOut(200);
    }else{
        $('.go_down').fadeIn(200);
    }
});

// radio player
var audioPlayer = document.getElementById('audio_player');
function playPause(){
    if(audioPlayer.paused == false){
        audioPlayer.muted = !audioPlayer.muted;
        if(audioPlayer.muted == true){
            $('.player-buttons .play-pause .pause').removeClass('pause').addClass('play');
        }else{
            $('.player-buttons .play-pause .play').removeClass('play').addClass('pause');
        }
    }

    if(audioPlayer.paused){
        audioPlayer.play();
        $('.player-buttons .play-pause .play').removeClass('play').addClass('pause');
    }


}

//radio player volume
$(function() {
    //audioPlayer.volume = 37 / 100;

    $( "#volume" ).slider({
        range: "min",
        value: 37,
        min: 1,
        max: 100,
        slide: function( event, ui ) {
            audioPlayer.volume = ui.value / 100;
            $("#volume_value").val(ui.value);
            tuneIcons(ui.value);
        }
    });

    $("#sound_icon").click(function(e){
        audioPlayer.muted = !audioPlayer.muted;
        if(audioPlayer.muted){
            $("#sound_icon span").removeClass('tune2');
            $("#sound_icon span").removeClass('tune3');
            $("#sound_icon span").addClass('mute');
        }else{
            tuneIcons($("#volume_value").val());
        }
        e.preventDefault();
    });
});

function tuneIcons(val){
    if(val > 50){
        $("#sound_icon span").addClass('tune3');
        $("#sound_icon span").removeClass('tune2');
        $("#sound_icon span").removeClass('mute');
    }
    if(val <= 50){
        $("#sound_icon span").removeClass('tune2');
        $("#sound_icon span").removeClass('tune3');
        $("#sound_icon span").removeClass('mute');
    }
    if(val <= 5){
        $("#sound_icon span").addClass('tune2');
        $("#sound_icon span").removeClass('tune3');
        $("#sound_icon span").removeClass('mute');
    }
}

//facebook gallery hover
$(document).ready(function(){
    $('.records-content ul li.item-list').hover(
        function(){
            $('.item-desc',$(this)).slideDown(300);
        },function(){
            $('.item-desc',$(this)).slideUp(300);
        }
    );
});


window.onpopstate = history.onpushstate = function() {
   // window.history.go(-1);
};


$.fn.bgSlider = function(options){
    var slider = this;
    var num = 1;
    var active;
    var settings = slider.extend({
        auto: true,
        changeTime: 8000,
        effectTime: 700,
        images: [
            '/theme/images/s1.png',
            '/theme/images/s5.jpg',
            '/theme/images/s2.png'
        ]
    },options);

    if(settings.images.length > 0){
        for(var i = 0; i<settings.images.length;i++){
            if(i <= 0)
                active = 'class="active"';
            else
                active = '';

            slider.append('<div '+active+' style="background:url('+settings.images[i]+') 50% 50% no-repeat;background-size:cover;"></div>');
        }
    }

    slider.changeBg = function(){
        if(num >= settings.images.length) num = 0;
        slider.find('div:eq('+num+')').fadeIn(settings.effectTime,function(){
            $(this).addClass('active');
        });
        slider.find('div.active').fadeOut(settings.effectTime,function(){
            $(this).removeClass('active');
        });
        num++;
    };
    //console.log(settings.auto);

    var interval = setInterval(slider.changeBg,settings.changeTime);
};




function shareWindow(name,e){
    window.open(e.href, ''+name+'','left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
    return false;
}

$(document).ready(function() {
    // check cookie
    var visited = $.cookie("visited")

    if (visited == null) {
        $("div.play-pause > a").trigger('click');
        $.cookie('visited', 'yes');
    }

    // set cookie
    $.cookie('visited', 'yes', { expires: 1, path: '/' });

    if($(".item-body-wrapper > p > img").length > 0){
        $(".item-body-wrapper p > img").removeAttr("width height").addClass("img-responsive");
    }

    if($(".read_content > p > img").length > 0){
        $(".read_content p > img").removeAttr("width height").addClass("img-responsive");
    }
});
