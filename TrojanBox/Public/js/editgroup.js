$(function () {
	$('#submit').click(function () {
		var publicSelect = $('#publicSelect').val();
		var publicName = $('#publicName').val();
		var publicKey = $('#publicKey').val();
		var id = $('#id').val();
		var publicDescription = $('#publicDescription').val();
		var message = $('#message');
		if (id == '') {
			message.html('请刷新');
			return false;
		}
		if (publicSelect == '') {
			message.html('请选择有效的归档目录！');
			return false;
		}
		if (publicName == '') {
			message.html('请填写归档名称！');
			return false;
		}
		$.post('/admin/group/ajax_editgroup', {'id':id,'key': publicKey, 'description': publicDescription, 'pid': publicSelect, 'name': publicName}, function (e) {
			if (e == '1') 
				window.location.href = '/admin/group/grouplist';
			else
				alert('添加失败！');
		})
	})
})