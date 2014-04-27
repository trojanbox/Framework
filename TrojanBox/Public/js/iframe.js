$(function(){
    $('[id^=menut]').click(function(){
        var _thisSuffix = this.id.substr(5);
        var _thisLiSize = $('#menuUl'+_thisSuffix).children('li').children('ul').children('li').size();
        $('.firstMenu').stop().animate({'height':'33px'});
        $('#menuUl'+_thisSuffix).stop().animate({'height':(_thisLiSize*33)+33+'px'});
    });
});


setInterval(function () {
    var winHeight = $(window).height();
    var winWidth = $(window).width();
    var leftHeight = $('.Left').height();
    var rightHeight = $('.Right').height();
    var height = 30;
    var width = 200;
    $('.iframeDiv').width(winWidth);
    if (leftHeight > rightHeight) $('.Right').height(winHeight-height);
    else $('.Left').height(rightHeight-height);
    if (winHeight > leftHeight) $('.Left').height(winHeight-height);
    if (winHeight > rightHeight) $('.Right').height(winHeight-height);
    $('.Right').width(winWidth-width);
}, 1000);