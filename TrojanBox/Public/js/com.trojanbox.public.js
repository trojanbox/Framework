$(function () {
	
	var searchText = '点击进行关键字搜素';
	
	$('#headMLDRDSeachText').focus(function () {
		if (this.value.toString() === searchText) {
			this.value = '';
		} 
	});
	
	$('#headMLDRDSeachText').keydown(function (event) {
		if (event.keyCode == 13) {
			alert('搜索功能尚未实现~~');
		}
	});
	
	$('#headMLDRDSeachText').blur(function () {
		if (this.value.toString() === '') {
			this.value = searchText;
		}
	});
});

var trojanbox = {
	'search' : function () {
		this.url = '';
		this.key = '';
		this.setUrl = function (url) {
			this.url = url;
		};
		this.setKey = function (key) {
			this.key = key;
		};
		this.submit = function () {
			alert(this.setUrl + '--->' + this.setKey);
		};
	}
};

$(function () {
	var pageSize = $('.bodyPageDiv').children('div').size();
	$('.bodyPageDiv').css({'width': (pageSize-4)*35 + (4*65) - 5 + 'px'});
})

	
