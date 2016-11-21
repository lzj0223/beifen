@extends('home._layout.default')


@section('header_css')
    <style>
        .dowmload-link{max-width: 100px;max-width: 500px;width: 60%;text-overflow: ellipsis;height: 20px;overflow: hidden;display: block;white-space:nowrap;}
        .kankan{margin-left: 10px}
        .article h1 {font-size: 30px;}
    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight article">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="pull-right">
                            @foreach($tags as $tag)
                                <a class="btn btn-white btn-xs" href="/tag/detail.html?id={{$tag['id']}}" title="{{$tag['tag']}}">{{$tag['tag']}}</a>
                            @endforeach
                        </div>
                        <div class="text-center article-title">
                            <h1>
                                {{$info->title}}
                            </h1>
                        </div>
                        <p style="word-break: break-all;">{!! $info->content !!}</p>
                        <p style="word-break: break-all;"><strong>BTFILM专业电影搜索引擎，海量电影等你来搜!</strong></p>

                        <div class="row" style="margin: auto auto;">
                            <div class="mail-box-header">
                                <b>下载地址（复制请用按钮复制,选中复制可能补全）</b>
                            </div>
                            <div class="mail-box">

                                <table class="table table-hover table-mail">
                                    <tbody>
                                    @foreach($sources as $key=>$source)
                                        <tr class="unread">
                                            <td class="mail-ontact" style="width: 65px;">地址{{($key + 1)}}:</td>
                                            <td class="mail-subject">
                                                <a href="{{$source->link}}" class="dowmload-link" id="dowmload-link-{{($key + 1)}}" target="_blank">{{$source->link}}</a>
                                            </td>
                                            <td class="text-right mail-date">
                                                <a href="{{$source->link}}" title="BTFILM下载" class="btn btn-sm btn-primary" style="color: #fff;"  target="_blank">下载</a>
                                                <button href="{{$source->link}}" class="btn btn-sm btn-primary copy-btn" style="color: #fff;"
                                                        data-clipboard-action="copy" data-clipboard-target="#dowmload-link-{{($key + 1)}}"
                                                        >复制</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mail-box-header">
                                <b>迅雷看看在线播放</b>
                            </div>
                            <div class="mail-box">
                                <table class="table table-hover table-mail">
                                    <tbody>
                                    <tr class="unread">
                                        <td class="text-left">
                                            @foreach($kankan as $key=>$v)
                                                <button type="button" class="kankan btn btn-sm btn-primary" onclick="start('{{$v}}}')">播放地址{{($key + 1)}}</button>
                                            @endforeach
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="alert alert-success">
                                BTFILM友情提示：如下载链接为百度网盘且需要密码，可前往原站查看密码。BT种子、磁力链接均可以通过115网盘、百度网盘、迅雷下载。
                                <a href="/bridge.html?url={{$info->gather_url}}" target="_blank" rel="nofollow">点此穿越至原站</a>
                            </div>
                            <div class="alert alert-danger" style=" font-size: 12px;text-indent:0em;">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                BTFILM声明：BTFILM提供的资源链接为网上搜集且注明来源，BTFILM未存储任何资源，不对内容负任何法律责任！若侵权，请联系BTFILM管理员删除链接！
                            </div>
                            <script src="/static/plugins/kankan/functions.js"></script>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- UY BEGIN -->
                                <div id="uyan_frame"></div>
                                <script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=2078876"></script>
                                <!-- UY END -->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('footer_script')
<script src="/static/plugins/Clipboard/clipboard.min.js"></script>
<script>
    $(document).ready(function(){
        var clipboard = new Clipboard('.copy-btn');
        clipboard.on('success', function(e) {
            layer.msg("复制成功",{icon:1});
            e.clearSelection();
        });
        clipboard.on('error', function(e) {
            layer.msg("复制失败",{icon:2});
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });
    });
</script>
@endsection

