/**
 * Created by it-solutions on 7/16/2015.
 */
$('.menu-list > ul > li.more ').hover(
    function(){
        $('ul',this).stop().slideDown();
        $('i.fa',this).removeClass('fa-caret-right');
        $('i.fa',this).addClass('fa-caret-down');
    },
    function(){
        $('ul',this).stop().slideUp();
        $('i.fa',this).removeClass('fa-caret-down');
        $('i.fa',this).addClass('fa-caret-right');
    }
);



$.fn.newPressSlider = function(options){

    var e = this;

    this.options = options;

    if(!this.options){
        this.options = {
            duration: 7000,
            length: 15
        }
    }


    $('.arrows .next').attr('style','left:' + (parseFloat(this.find('div ul:last-child').width()) + 30) + 'px;');

    this.find('div ul:first-child li:first-child').addClass('active');
    this.find('div ul:last-child li:first-child').addClass('active');
    this.fade = function() {
        var li = e.find('div ul:first-child li.active').index();
        var num = e.options.length - 1;
        var next = li + 1;

        e.find('div ul:first-child li:eq(' + li + ')').fadeOut('slow').removeClass('active');
        e.find('div ul:first-child li:eq(' + next + ')').fadeIn('slow').addClass('active');
        e.find('div ul:first-child li:eq(' + li + ')').removeClass('active');
        e.find('div ul:first-child li:eq(' + next + ')').addClass('active');
        e.find('div ul:last-child li:eq('+li+')').removeClass('active');
        e.find('div ul:last-child li:eq('+next+')').addClass('active');
        if(li >= num){
            e.find('div ul:first-child li:eq(0)').fadeIn('slow').addClass('active');
        }


    };

    //var slide = this.fade;
    var interval = setInterval(this.fade,this.options.duration);

    this.hover(function(){
            clearInterval(interval);
        },function(){
           interval = setInterval(e.fade,e.options.duration);
        }
    );

    this.find('div ul:last-child li').click(function(){
        e.find('div ul:last-child li.active').removeClass('active');
        $(this).addClass('active');
        e.find('div ul:first-child li.active').fadeOut('slow').removeClass('active');
        e.find('div ul:first-child li:eq('+$(this).index()+')').fadeIn('slow').addClass('active');
    });

    this.find('div:last-child a').click(function(){
        var li = e.find('div ul:first-child li.active').index();
        var num = e.options.length - 1;
        var next = li + 1;
        var prev = li - 1;
        if($(this).attr('class') == 'next'){
            e.find('div ul:last-child li.active').removeClass('active');
            e.find('div ul:first-child li.active').fadeOut('slow').removeClass('active');
            e.find('div ul:last-child li:eq('+next+')').addClass('active');
            e.find('div ul:first-child li:eq('+next+')').fadeIn('slow').addClass('active');
            if(li >= num){
                e.find('div ul:last-child li:eq(0)').addClass('active');
                e.find('div ul:first-child li:eq(0)').fadeIn('slow').addClass('active');
            }
        }
        if($(this).attr('class') == 'prev'){
            e.find('div ul:last-child li.active').removeClass('active');
            e.find('div ul:first-child li.active').fadeOut('slow').removeClass('active');
            e.find('div ul:last-child li:eq('+prev+')').addClass('active');
            e.find('div ul:first-child li:eq('+prev+')').fadeIn('slow').addClass('active');
            if(li <= 0){
                e.find('div ul:first-child li:eq('+num+')').fadeIn('slow').addClass('active');
            }
        }
    });
};

$(".slider").newPressSlider();



$(".daily ul").niceScroll({touchbehavior:false,cursorcolor:"#e8e8e8",cursoropacitymax:0.6,cursorwidth:8});



$.fn.imageSlider = function(options){

    var e = this;

    this.options = {
        imageNum: 3,
        speed: 300
    };

    this.options = $.extend(this.options,options);

    this.num = this.find('ul li').length;

    this.width = this.find('ul li').width();

    this.maxWidth = this.num * this.width + (this.num * 5);

    this.conWidth = parseFloat(this.width * this.options.imageNum) + (this.num + this.options.imageNum);

    this.find('div:nth-child(2)').attr('style','width:'+this.conWidth+'px;margin:0 2px 0 2px;overflow:hidden');


    this.find('ul').attr('style','width:'+this.maxWidth+'px');



    this.find('div:nth-child(1) a').bind('click',function(){
        var ul = $(this).parent('div').parent('div').find('div:nth-child(2) ul');
        ul.animate({left:"-="+e.conWidth+'px'},500);
        ul.animate({left:'0px'},0,function(){
            for(var i = 0; i<(e.options.imageNum); ++i){
                ul.find('li:first-child').appendTo(ul);
            }
        });

    });



    this.find('div:nth-child(3) a').bind('click',function(){
        var ul = $(this).parent('div').parent('div').find('div:nth-child(2) ul');
        ul.animate({left:"-="+e.conWidth+'px'},0,function(){
            for(var i = e.num; i>(e.num - e.options.imageNum); --i){
               ul.find('li:last-child').prependTo(ul);
            }
        });

        ul.animate({left:"+="+e.conWidth+'px'},500);
    });

};

$(document).ready(function(){
    $('#imageSlider').imageSlider({imageNum:6});
    $('#partnerSlider').imageSlider({imageNum:3});
});


function clock() {
    var d = new Date();
    var day = d.getDate();
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var seconds = d.getSeconds();

    var month = new Array("იანვარი", "თებერვალი", "მარტი", "აპრილი", "მაისი", "ივნისი",
        "ივლისი", "აგვისტო", "სექტემბერი", "ოქტომბერი", "ნოემბერი", "დეკემბერი");
    var days = new Array("კვირა","ორშაბათი", "სამშაბათი", "ოთხშაბათი","ხუთშაბათი", "პარასკევი","შაბათი");

    if (day <= 9) day = "0" + day;
    if (hours <= 9) hours = "0" + hours;
    if (minutes <= 9) minutes = "0" + minutes;
    if (seconds <= 9) seconds = "0" + seconds;

    var date_date = days[d.getDay()] + ", " + day + " " + month[d.getMonth()] + ", " + d.getFullYear() + " წელი";
    var date_time = hours + ":" + minutes + ":" + seconds;

    if (document.layers) {
        document.layers.date.document.write(date_time);
        document.layers.date.document.close();
        document.layers.time.document.write(date_time);
        document.layers.time.document.close();
    }
    else {
        document.getElementById("date").innerHTML = date_date;
        document.getElementById("time").innerHTML = date_time;
    }
    setTimeout("clock()", 1000);
}
clock();


function shareWindow(name,e){
    window.open(e.href, ''+name+'','left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
}


$('.currency-nav a').click(function(){

    if($('.curr li:last-child').attr('class') == 'active'){
        $('.curr li:last-child').removeClass('active').addClass('inactive');
        $('.curr li:first-child').addClass('active').removeClass('inactive');
    }else{
        $('.curr li:last-child').addClass('active').removeClass('inactive');
        $('.curr li:first-child').removeClass('active').addClass('inactive');
    }

});
