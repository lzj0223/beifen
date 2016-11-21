<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$seo_info['title'] or 'BTFILM'}}</title>
    <meta name="keywords" content="{{$seo_info['keywords'] or 'BTFILM'}}">
    <meta name="description" content="{{$seo_info['desc'] or 'BTFILM'}}">
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
    @yield('header_css')
</head>
<body>
<div class="page-group">
    <div class="page page-current" id="page-infinite-scroll-bottom">

        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
@yield('footer_script')
</body>
</html>