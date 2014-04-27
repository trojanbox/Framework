$(function(){
    document.getElementById('submit').onclick = function (){
        var publicText = document.getElementById('public');
        var messageBox = document.getElementById('messageBox');
        var preg = /.*(;).*/gi;
        if (publicText.value.length == '0'){
            messageBox.innerHTML = "<font style='color:red;'>卧槽，你倒是请输入登录信息啊，这种错误还要犯多少次！</font>";
            return false;
        }
        
        if (publicText.value.match(preg) == null) {
            messageBox.innerHTML = "<font style='color:red;'>哥，格式错了！</font>";
            return false;
        }
        messageBox.innerHTML = "<font style='color:#00abdc;'>欢迎登录，正在请求服务器...</font>";
        $.post(
            '/admin/user/verify',
            {data:publicText.value},
            function(e){
                switch(e){
                    case 'not args':
                    messageBox.innerHTML = "<font style='color:#FF9B00;'>额，传过来的值出现了一点错误。要不你刷新页面重试一下？</font>";
                    break;
                    case 'args error':
                    messageBox.innerHTML = "<font style='color:#FF9B00;'>格式错了重试吧，别跟我说你不知道为什么！</font>";
                    break;
                    case 'login error':
                    messageBox.innerHTML = "<font style='color:red;'>校验失败，你提供的用户名和密码组合不正确！</font>";
                    break;
                    case 'login ok':
                    messageBox.innerHTML = "<font style='color:#00abdc;'>校验成功，将跳转到管理后台！</font>";
                    window.location.href = '/admin/index/index';
                    break;
                    default:
                    messageBox.innerHTML = messageBox.innerHTML = "<font style='color:#FF9B00;'>你脸太黑了！这问题我没法解决。</font>";
                    break;
                }
            }
        );
    }
})
