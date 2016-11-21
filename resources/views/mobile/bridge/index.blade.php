@extends('home._layout.default')


@section('header_css')
    <style type="text/css">
        body {font-family: "微软雅黑","Open Sans",helvetica,arial,sans-serif;}
        #container {width: 300px; margin: 0 auto; height: 100%;}
        .error-code {
            color:#ccc;
            text-shadow: 0 2px 3px #ccc, 0px -2px 1px #fff;
            font-weight: bold;
            letter-spacing: -4px;
            text-align: center;
            border-radius: 20px;
            text-align: center;
            vertical-align: middle;
        }
        .clear {clear: both; }
        .error-msg {text-align: center;}
    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight article" style="height: 88%">
        <div id="container">
            <div class="error-code"><strong>BTFILM专业电影搜索引擎，海量电影等你来搜</strong></div>
            <div class="clear"></div>
            <div class="error-msg">{{$msg}}</div>
        </div>
    </div>
@endsection


@section('footer_script')

<script>
    var  jump = function (){
        window.location.href = "{{$url}}";
    }
    setTimeout(jump,3);
</script>
@endsection
