<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$seo_info['title'] or 'BTFILM'}}</title>
    <meta name="keywords" content="{{$seo_info['keywords'] or 'BTFILM'}}">
    <meta name="description" content="{{$seo_info['desc'] or 'BTFILM'}}">
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">
    <link href="http://apps.bdimg.com/libs/fontawesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://apps.bdimg.com/libs/animate.css/3.1.0/animate.min.css" rel="stylesheet">
    <link href="/static/css/style.min.css" rel="stylesheet">
    <style>
        #page-wrapper{
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1;
        }
        .footer{
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        #wrapper{padding-bottom: 36px;}
    </style>
    @yield('header_css')
</head>

<body  class="gray-bg top-navigation" style="height: 100%">
<div id="wrapper" class="gray-bg" style="background-color: #f3f3f4;height: 100%">
    <div id="page-wrapper" class="row border-bottom white-bg">
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="/" class="navbar-brand">BTFILM</a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav" data-id="{{$nav_id or ''}}">
                    <li class="" data-id="Index-index">
                        <a aria-expanded="false"  class="" data-toggle="" role="button" href="/"> 首页</a>
                    </li>
                    <li class="" data-id="Hot-index">
                        <a aria-expanded="false" class="" data-toggle="" role="button" href="/hot.html"> 院线热播</a>
                    </li>
                    <li class="" data-id="Index-gather">
                        <a aria-expanded="false" class="" data-toggle="" role="button" href="/new.html"> 最新收录</a>
                    </li>
                    <li class="" data-id="Tag-index">
                        <a aria-expanded="false" class="" data-toggle="" role="button" href="/tag.html"> 标签库</a>
                    </li>
                    <li class="" data-id="Help-index">
                        <a aria-expanded="false" class="" data-toggle="" role="button" href="/help.html"> 下载教程</a>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right">
                    <!--<li>
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> 退出

                            <i class="fa fa-sign-in"></i> 登录
                        </a>
                    </li>-->
                </ul>
            </div>
        </nav>
    </div>
    <div style="height: 70px;"></div>
    @yield('content')


    <div class="footer">
        <div class="pull-right">
            <a href="/sitemap.html" title="BTFILM网站地图">网站地图</a> -
            <a rel="nofollow" href="mailto:btfilmcn@sina.com" title="BTFILM站长信箱">BTFILM站长信箱</a>
        </div>
        <div>
             <strong>Copyright</strong> <a href="/" title="BTFILM专业电影搜索引擎">BTFILM</a> © 2015
        </div>
    </div>

</div>

<!-- 全局js -->
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://apps.bdimg.com/libs/layer/2.1/layer.js"></script>
<div style="display:none"><script src="http://s95.cnzz.com/z_stat.php?id=1256655633&web_id=1256655633" language="JavaScript"></script></div>
@yield('footer_script')
<script>
    $(function(){
        var currMenu = $('#navbar > ul').data("id");
        $("li[data-id='" + currMenu +"']").addClass('active');
        console.group("BTFILM 专业的电影搜索引擎");
        console.log("欢迎加入115 BTFILM社区：http://115.com/20027402");
        console.log("欢迎加入115 PHPer社区：http://115.com/153332");
        console.log("欢迎来邮件提建议：btfilmcn@sina.com");
        console.groupEnd();
    });
    //百度分享
    window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"0","bdPos":"right","bdTop":"160.5"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];

(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>

</body>

</html>