@extends('home._layout.default')


@section('header_css')
    <link rel="stylesheet" href="/css/basic.css" type="text/css">
    <link rel="stylesheet" href="/css/new_css20160428.css" type="text/css">
@endsection

@section('content')
    <div class="">
        <div class="jcct_top ofh mtauto ">

            <div class="" style="">
                <h3 class="fs26">BTFILM支持迅雷、百度云、115</h3>
                <hr />
                <p class="fs14 fc6 lh24" style="line-height:40px;border-left:2px solid #fcb800;padding-left: 26px;">
                    1、想要在线观看的，请保存到网盘中观看。没有网盘链接，请百度搜索：百度云离线下载教程或115离线下载教程。<br/>
                    2、如需下载电影，请先安装迅雷（旋风），然后点击按钮或者右键复制资源链接，选择迅雷（旋风）下载。<br/>
                    3、本站提供的磁力链接/ftp等资源支持迅雷看看边下边播模式，点击播放地址即可调用迅雷看看播放器，请先安装迅雷看看播放器。
                </p>
                <ul class="ofh play_platform mtauto" style="width: 86%">
                    <li class="fl">
                        <a href="#">
                            <img src="/images/xunlei_ico.png" alt="btfilm迅雷下载教程"/>
                            <span class="lh40">迅雷</span>
                        </a>
                    </li>
                    <li class="fl">
                        <a href="#">
                            <img src="/images/baiduyun_ico.png" alt="btfilm百度云下载教程"/>
                            <span class="lh40">百度云</span>
                        </a>
                    </li>
                    <li class="fl">
                        <a href="#">
                            <img src="/images/115_ico.png" alt="btfilm115下载教程"/>
                            <span class="lh40">115</span>
                        </a>
                    </li>
                </ul>

            </div>

        </div>
    </div>
    <div class="jcct_mainbox">
        <div class="jcct_main ofh mtauto">
            <div class="jcct_mainpos">
                <p class="jcct_main_title fs24 lh48">海量电影 抢先观看更流畅</p>
                <p class="fs14 fc6">
                    <span class="lh24">无需下载，更快捷，让电脑更省空间</span><br/>
                    <span class="lh24">抢先观看，无需注册会员，更自由</span><br/>
                    <span class="lh24">无广告，不忧心，更专注</span>
                </p>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')

@endsection

