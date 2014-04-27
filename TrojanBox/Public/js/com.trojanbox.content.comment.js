
var comTrojanContent = {
	'commentWindow' : function () {
		this.open = function () {
			$('.com-trojanbox-abscomment-frame').css({'display': ''});
			return this;
		};
		
		this.close = function () {
			$('.com-trojanbox-abscomment-frame').css({'display': 'none'});
			return this;
		};
		
		this.clear = function () {
			$('#commentUserName').val('');
			$('#commentContent').val('');
			return this;
		};
	},
	'commentLists' : function () {
		this.getLists = function () {
			$('.com-trojanbox-comment-lists').html("<div style='width: 100%;height: 100px;text-align: center;line-height: 100px;font-size: 21px;'>正在刷新评论...</div>");
			$.post(
			'/home/comment/ajax_getlists', 
			{}, 
			function (e) {
				$('.com-trojanbox-comment-lists').html(e);
			});
		};
	},
	'submitComment' : function () {
		this.username;
		this.content;
		this.floor;
		
		this.setUserName = function (username) {
			this.username = username;
			return this;
		};
		
		this.setContent = function (content) {
			this.content = content;
			return this;
		};
		
		this.setFloor = function (floor) {
			this.floor = floor;
			return this;
		};
	}
};

this.thisFloor = 0;

$(function () {
	
	var trojanboxContent = new comTrojanContent.commentWindow();
	
	//打开评论窗口
	$('.com-trojanbox-comment-title').click(function () {
		trojanboxContent.clear().open();
		$('#message-author').html('创建新评论');
		$('#message').html('');
		window.thisFloor = 0;
	});
	
	//关闭评论窗口
	$('#closeWindow').click(function () {
		trojanboxContent.close().clear();
		window.thisFloor = 0;
		$('#message').html('');
	});
	
	//评论提交
	$('#submitComment').click(function () {
		var commentUserName = $('#commentUserName');
		var commentContent = $('#commentContent');
		if (thisFloor == undefined) thisFloor = 0;
		
		if (commentUserName.val() === '' || commentContent.val() === '') {
			$('#message').html('请补全信息！');
			return false;
		}
		
		$.post('/home/comment/ajax_add', 
		{'username': commentUserName.val(), 'content': commentContent.val(), 'floor': thisFloor}, 
		function (e) {
			if (e == 'data') {
				new comTrojanContent.commentLists().getLists();
				trojanboxContent.close();
				window.thisFloor = 0;
				window.autoHeight();
			} else {
				$('#message').html('发布失败！');
			}
		});
	});

	new comTrojanContent.commentLists().getLists();
});