@extends('home._layout.default')


@section('header_css')
    <style>
        .info-box ul li{float: left;margin:0 10px;list-style: none}
        .search-title{float: left;max-width:80%; text-overflow: ellipsis;height: 17px;overflow: hidden;white-space:nowrap; }
    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight" style="min-height: 88%">
        <div class="row">
            <div class="col-sm-8" style="float: none;margin: auto auto;">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <h2>
                            BTFILM为您找到相关结果约{{$total}}个： <span class="text-navy">“{{$tag->tag}}”</span>
                        </h2>
                        <small>搜索用时  ({{$time_search}}秒)</small>——
                        <small>BTFILM专业电影搜索引擎，海量电影等你来搜</small>
                        <div class="search-form">
                            <form action="/" method="get">
                                <div class="input-group">
                                    <input type="text" placeholder="想搜点什么..." value="" name="search" class="form-control input-lg">
                                    <div class="input-group-btn">
                                        <button class="btn btn-lg btn-primary" type="submit">
                                            搜索
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        @foreach($films as $film)
                            <div class="hr-line-dashed"></div>
                            <div class="search-result">
                                <div>
                                    <h3 class="search-title" style="">
                                        <a href="/{{$film->id}}.html" target="_blank"
                                           title="{{$film->title}}">
                                            【BTFILM】{!! highLight(array($tag->tag),$film->title) !!}
                                        </a>
                                    </h3>
                                    <span class="search-link" style="float: right;">{{substr($film->c_time,0,10)}}</span>
                                </div>
                                <p class="search-link" style="clear: both;">来源：{{$film->gather_url}}</p>
                                <p style="clear: both;height: 50px;overflow: hidden;">{!!highLight(array($tag->tag),strip_tags($film->summary))!!}</p>
                                <p class="" style="clear: both;">
                                    @foreach($film->tags as $v)
                                        <a class="label" title="BTFILM标签:{{$v['tag']}}"
                                           style="margin-right: 10px" href="/tag/detail.html?id={{$v['id']}}">{{$v['tag']}}</a>
                                    @endforeach
                                </p>
                            </div>
                        @endforeach
                        <div class="hr-line-dashed"></div>
                        <div class="text-center" id="page">
                            {!!$page!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')


@endsection

