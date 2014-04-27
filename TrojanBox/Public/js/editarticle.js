window.onload = function() {
    document.getElementById('lookArticle').onclick = function (){
    	var id = document.getElementById('id');
        var titleText = document.getElementById('titleText');
        var messageBox = document.getElementById('messageBox');
        var classify = document.getElementById('classify');
        var description = document.getElementById('description');
        var key = document.getElementById('key');

        //安全性验证
        if (id.value.length <= 0) {
            messageBox.innerHTML = '请刷新页面';
            return false;
        }

        if (titleText.value.length <= 0) {
            messageBox.innerHTML = '标题内容不允许为空。';
            return false;
        }
        
        if (classify.value.length <= 0) {
            messageBox.value.length = '请选择一个有效分类。';
            return false;
        }
        
        if (key.value.length <= 0) {
            messageBox.innerHTML = '请填写关键字，多关键字用\',\'号分割。';
            return false;
        }
        
        if (description.value.length <= 0) {
            messageBox.innerHTML = '请填写关键字，多关键字用\',\'号分割。';
            return false;
        }
        if (CKEDITOR.instances.editor01.getData().length <= 0) {
            messageBox.innerHTML = '内容为空！你想要表达什么？';
            return false;
        }  //获取编辑器信息
        
        //将关键字分割成Json发送到服务器
        $.post(
        '/Admin/Article/Ajax_EditArticle',
        {'id':id.value,'titleText':titleText.value,'classify':classify.value,'key':key.value,'description':description.value,'content':CKEDITOR.instances.editor01.getData()},
        function (e){
            if (e == 'ok') {
            	messageBox.innerHTML = '编辑成功。';
            	window.location.href = '/admin/article/articlelist';
            } else messageBox.innerHTML = '编辑失败。';
        })
    }
    CKEDITOR.replace( 'editor01' );
};

//自定义函数
(function (window){
    var _master = {};
    
    // 字符切割转Json
    _master.strToJson = function (string,split){
        var jsonString = '{';
        string = string.toString();
        strArray = string.split(';');
        for(data in strArray)
            jsonString += "'" + strArray[data] + "'" + ',';
        jsonString = jsonString.substr(0,jsonString.length*1-1);
        jsonString += '}';
        return jsonString;
    }
    window.master = _master;
})(window)
