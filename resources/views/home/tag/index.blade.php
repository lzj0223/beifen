@extends('home._layout.default')


@section('header_css')
    <style>
        .info-box ul li{float: left;margin:0 10px;list-style: none}
        .label{margin: 10px;white-space:inherit;display: block;float: left}
        .wrapper-content{min-height: 88%}
        #page{margin: 0 auto;text-align: center}
    </style>
@endsection

@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight article">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row" style="margin-bottom: 30px;">
                            <div>
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
                            </div>
                        </div>
                        <div class="row">
                            @foreach($tags as $key=>$tag)
                                <a class="label <?php if($key%6==0){ echo 'label-warning';}elseif($key%5==0){echo 'label-info';}elseif($key%4==0){echo 'label-success';}elseif($key%3==0){echo 'label-primary';}elseif($key%2==0){echo 'label-danger';} ?>"
                                   href="/tag/detail.html?id={{$tag['id']}}" title="btfilm:{{$tag['tag']}}">{{$tag['tag']}}</a>
                            @endforeach
                        </div>
                        <hr>
                        <div class="row">
                            <div id="page">
                                {!! $page !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')


@endsection

