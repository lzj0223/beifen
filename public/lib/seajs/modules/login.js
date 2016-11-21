/** login */
define(function(require, exports, module) {

    var cache_publickey_str = 'publickey';
    var loading_image = '<img width="18" src="images/loading-icons/loading7.gif">';
    var login_form_obj = $('#login-form');
    var msg_obj = $('#msg');
    var submit_obj = $('#submit');
    var loading = false;

    var $_GET = (function(){
        var url = window.document.location.href.toString();
        var u = url.split("?");
        if(typeof(u[1]) == "string"){
            u = u[1].split("&");
            var get = {};
            for(var i in u){
                var j = u[i].split("=");
                get[j[0]] = j[1];
            }
            return get;
        } else {
            return {};
        }
    })();

    //登录
    function login(username, password) {
        $.ajax({
            type: "get",
            url: "/login/proc",
            data: {username:username,password:password},
            dataType: "jsonp",
            jsonp: "callback",
            jsonpCallback:"callback",
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var icon = 1;
                if(!data.result) {
                    prelogin(true);
                    icon = 2;
                }
                layer.msg(data.msg,{icon: icon});
                if(data.result && typeof data.jumpUrl != 'undefined') {
                    window.location.href = data.jumpUrl;
                }else if(data.result) {
                    window.location.href = '/';
                }
            },
            beforeSend: function() {
                loading = layer.load();
                submit_obj.html(loading_image);
            },
            timeout: 30000,
            complete: function(request, status) {
                if(status == 'timeout') {
                    layer.msg('登录超时，请重试！',{icon: 2});
                }
                submit_obj.html('登录');
            }
        });
    }

    //登录前处理
    function prelogin(is_show_loading) {
        $.ajax({
            type: "get",
            url: "/login/prelogin",
            data: "",
            dataType: "jsonp",
            jsonp: "callback",
            jsonpCallback:"callback",
            success: function(data) {
                $('input').attr('disabled', false);
                //确保正确返回了数据才会显示登录框
                if( ! is_show_loading) {
                    layer.close(loading);
                }
                submit_obj.data(cache_publickey_str, data.pKey);
                $('meta[name="csrf-token"]').attr('content', data.a);
            },
            beforeSend: function() {
                $('input').attr('disabled', true);
                submit_obj.html(loading_image);
            },
            timeout: 10000,
            complete: function(request, status) {
                if(status == 'timeout') {
                    layer.msg('网络错误！',{icon: 2});
                }
                submit_obj.html('登录');
                layer.closeAll('loading');
            }
        });
    }


    //侦听登录的点击事件
    function submit() {
        submit_obj.on('click', function() {
            var username = $('#username').val();
            var password = $('#password').val();
            if(username == '') {
                layer.msg('请输入用户名',{icon: 2});
                return false;
            }
            if(password == '') {
                layer.msg('请输入密码',{icon:2});
                return false;
            }
            password = CryptoJS.MD5(password);
            var publickey = submit_obj.data(cache_publickey_str);
            if(typeof publickey == 'undefined') {
                layer.msg('登录失败，非法操作。',{icon:2});
                return false;
            }
            password = password + publickey;
            password = (""+CryptoJS.MD5(password)).toUpperCase();
            login(username, password);
        });
    }

    return {
        login:login,
        prelogin:prelogin,
        submit:submit
    }

});