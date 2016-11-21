@extends('home._layout.default')


@section('header_css')
    <style>
        .info-box ul li{float: left;margin:0 10px;list-style: none}
        .search-title{float: left;max-width:80%; text-overflow: ellipsis;height: 17px;overflow: hidden;white-space:nowrap; }
        .highlight{color: red}
        .f-sort {margin-top: 5px;padding-left: 15px;}
        .f-sort a {
            float: left;
            padding: 0 10px;
            height: 23px;
            border: 1px solid #CCC;
            line-height: 23px;
            margin-right: -1px;
            background: #FFF;
            color: #333;
            text-decoration: none;
        }
        .f-sort a.curr {
            background: #e4393c;
            color: #FFF;
            border-color: #e4393c;
        }
        .f-sort a.down,.f-sort a.up {
            position: relative;
            padding-right: 20px;
        }
        .f-sort a.down i {background-position: 0 -203px;}
        .f-sort a.up i {background-position: 0 -225px;}
        .f-sort a.down i,.f-sort a.up i {display: block;}
        .f-sort a i {display: none;  position: absolute;background: url("../static/img/search.ele.png") no-repeat -9999px -9999px;  top: 6px;  right: 5px;width: 13px;height: 12px; overflow: hidden;font-size: 0;  }

    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight" style="min-height: 88%">
        <div class="row">
            <div class="col-sm-8" style="float: none;margin: auto auto;">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <h2>
                            BTFILM为您找到相关结果约{{$total or 0}}个： <span class="text-navy">“{{$keyword}}”</span>
                        </h2>
                        <small>搜索用时  ({{$time_search}}秒)</small>——
                        <small>BTFILM专业电影搜索引擎，海量电影等你来搜</small>
                        <div class="search-form">
                            <form action="/" method="get">
                                <div class="input-group">
                                    <input type="text" placeholder="想搜点什么..." value="{{$keyword}}" name="search" class="form-control input-lg">
                                    <div class="input-group-btn">
                                        <button class="btn btn-lg btn-primary" type="submit">
                                            搜索
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="row">
                            <div class="f-sort">
                                {!! widget('Home.Search')->sortMenu($sort,$keyword) !!}
                            </div>
                        </div>
                        @foreach($films as $film)
                            <div class="hr-line-dashed"></div>
                            <div class="search-result">
                                <div>
                                    <h3 class="search-title" style="">
                                        <a href="/{{$film->id}}.html" target="_blank"
                                           title="{{$film->title}}">
                                            【BTFILM】{!! $film->highlightTitle !!}
                                        </a>
                                    </h3>
                                    <span class="search-link" style="float: right;">{{substr($film->c_time,0,10)}}</span>
                                </div>
                                <p class="search-link" style="clear: both;">来源：{{$film->gather_url}}</p>
                                <p style="clear: both;height: 50px;overflow: hidden;">{!! $film->content !!}</p>
                                @if(is_array($film->tags))
                                <p class="" style="clear: both;">
                                    @foreach($film->tags as $v)
                                        <a class="label" title="BTFILM标签:{{$v['tag']}}"
                                           style="margin-right: 10px" href="/tag/detail.html?id={{$v['id']}}">{{$v['tag']}}</a>
                                    @endforeach
                                </p>
                                @endif
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

