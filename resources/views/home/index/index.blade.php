@extends('home._layout.default')


@section('header_css')
    <style>
        .info-box ul li{float: left;margin:0 10px;list-style: none}
    </style>
@endsection

@section('content')
    <div class="text-center animated fadeInDown" style="height: 88%;padding: 10% 0;">
        <h2 class="font-bold" style=""><img src="/logo.png" style="height: 90px;" alt="BTFILM专业的电影搜索引擎，海量电影等你来搜"></h2>
        <div class="row text-center" style="width: 50%;margin: 25px auto;min-width: 300px">
            <div>
                <form action="/" method="get" class="text-center">
                    <div class="input-group">
                        <input type="text" placeholder="想搜点什么..." name="search" class="form-control input-lg">
                        <div class="input-group-btn">
                            <button class="btn btn-lg btn-primary" type="submit">
                                搜索
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="info-box">
                <ul>
                    @foreach ($tags as $tag)
                        <li>
                            <a href="/tag/detail.html?id={{$tag->id}}" title="BTFILM搜索:{{ $tag->tag }}">{{ $tag->tag }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection


@section('footer_script')


@endsection

