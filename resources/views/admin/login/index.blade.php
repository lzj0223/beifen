<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>H+ 后台主题UI框架 - 登录</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/font-awesome.min.css" rel="stylesheet">
    <link href="/static/css/animate.min.css" rel="stylesheet">
    <link href="/static/css/style.min.css" rel="stylesheet">
    <link href="/static/css/login.min.css" rel="stylesheet">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>" />
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>
    <style>
        .layui-layer-msg{color:#676A6A !important;}
    </style>
</head>

<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>[ H+ ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>H+ 后台主题UI框架</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五</li>
                    </ul>
                    <strong>还没有账号？ <a href="{{ url('/auth/register') }}">立即注册&raquo;</a></strong>
                </div>
            </div>
            <div class="col-sm-5">
                <div id="login-form" role="form" method="get" action="{{ url('/login/proc') }}" id="login-form">
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到H+后台主题UI框架</p>
                    <input type="text" class="form-control uname" placeholder="用户名" id="username" value="{{ old('email') }}"/>
                    <input type="password" class="form-control pword m-b" placeholder="密码" id="password"/>
                    <div style="float: left;color: rgb(51, 122, 183);"><input name="remember" type="checkbox" class="i-checks">自动登录</div>
                    <div style="float: right"><a href="{{ url('/password/email') }}">忘记密码了？</a></div>
                    <button class="btn btn-success btn-block" type="submit" id="submit">登录</button>
                </div>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2015 All Rights Reserved. H+
            </div>
        </div>
    </div>
    <script src="<?php echo loadStatic('/static/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo loadStatic('/static/js/plugins/layer/layer.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo loadStatic('/crypto/md5.js'); ?>" ></script>
    <script type="text/javascript" src="<?php echo loadStatic('/lib/seajs/sea.js'); ?>" ></script>

    <script type="text/javascript">
        seajs.config({
            base: "/lib/seajs/modules/",
            alias : {
                "jquery" : "jquery.js"
            }
        });

        seajs.use('login', function(login) {
            login.submit();//侦听登录按钮的点击事件
            login.prelogin();//取得一次性的密钥
        });

        $(document).ready(function(){
            $('.login-form').keyup(function(event){
                if (event.keyCode == 13) {
                    $('#submit').trigger('click');
                }
            });
        });

    </script>
</body>
</html>