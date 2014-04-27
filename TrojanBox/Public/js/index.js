// 自动同步左右栏高度


setInterval(function () {
	var bodyMainLeftHeight = $('.bodyMainLeft').height();
	var bodyMainRightHeight = $('.bodyMainRight').height();
	if (bodyMainLeftHeight > bodyMainRightHeight) $('.bodyMainRight').css({'height':bodyMainLeftHeight+'px'});
	if (bodyMainRightHeight > bodyMainLeftHeight) $('.bodyMainLeft').css({'height':bodyMainRightHeight+'px'});
}, 100);

$(function() {
    
    $("#headNaviMain li").hover(function() {
        var a = $(this).children('ul').children('li').size();
        $(this).children('ul').css("display","block").css("height",a*40);
    },function() {
        $(this).children('ul').css("display","none").css("height",0);
    })
})
