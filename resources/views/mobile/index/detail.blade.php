@extends('mobile._layout.default')


@section('header_css')
    <style>
        .dowmload-link{
            max-width: 100px;max-width: 500px;width: 60%;text-overflow: ellipsis;height: 20px;overflow: hidden
        ;display: block;white-space:nowrap;-webkit-touch-callout: inherit !important;}
        .tips{margin-top: 1rem;background-color: rgba(156, 156, 160, 0.24);padding: 0.1rem 1rem;border-radius: 1rem;font-size: 0.5rem}
        .list-block{margin: 0.75rem 0;}
        .font-size01{font-size: 0.1rem;}
    </style>
@endsection

@section('content')

    <div style="background-color: #fff;padding: 1rem 0;">
        <h2 style="text-align: center;margin-top: 0">{{$info->title}}</h2>
        <div class="content-padded">
            {!! $info->content !!}
        </div>
    </div>



    <div class="list-block">
        <ul>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <h4 style="margin: 0;">资源地址</h4>
                    </div>
                </div>
            </li>
            @foreach($sources as $key=>$source)
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">地址{{($key + 1)}}:</div>
                            <div class="item-input">
                                <a href="{{$source->link}}" class="dowmload-link external" external id="dowmload-link-{{($key + 1)}}">{{$source->link}}</a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>

    <div>
        <div class="card" style="margin: 0">
            <div class="card-content">
                <div class="card-content-inner">
                    <ol style="margin: 0;padding: 0.1rem 1rem">
                        <li>若点链接无法下载,可长按链接复制地址</li>
                        <li>如链接为百度云且需密码,可至<a href="/bridge.html?url={{$info->gather_url}}" rel="nofollow">原站</a>查看</li>
                        <li>资源为网上搜集且有来源,未存储任何资源!若侵权,联系管理员删除btfilmcn@sina.com</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer_script')

@endsection

