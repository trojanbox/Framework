//多级评论
var trojanboxContent = new comTrojanContent.commentWindow();

$('[id^=ctcc]').click(function () {

	var floor = this.id.split('-');
	window.thisFloor = floor[1];
	var author = $('.com-trojanbox-comment-user' + floor[2]).html();
	$('#message-author').html(' 评论到：' + author);
	trojanboxContent.clear().open();
	return false;
});