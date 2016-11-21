@extends('home._layout.default')
@section('header_css')
    <style>

    </style>
    <link rel="stylesheet" href="/css/new_css20160428.css">
@endsection
@section('content')
    <div class="article" style="width: 50%;min-width: 710px;margin-top: 40px">
        <h3>
            {{$info['title']}}
        </h3>
        <div class="indent clearfix">
            <div class="subjectwrap clearfix">
                <div class="subject clearfix">
                    <div id="mainpic" class="">
                        <img src="{{$info['mainpic']}}" title="点击看更多海报" alt="{{$info['title']}}">
                        <div id="interest_sect_level" class="clearfix">
                            <a href="/?search={{$info['title']}}" class="j a_show_login colbutt ll" title="btfilm搜索"><span>想看</span></a>
                        </div>
                    </div>
                    <div id="info">
                        {!! $info['info'] !!}
                    </div>
                </div>
                <div id="interest_sectl">
                    {!! $info['interest_sectl'] !!}
                </div>
            </div>

        </div>
        <div class="related-info" style="margin-bottom:-10px;">
            {!! $info['detail'] !!}
        </div>
        <div id="related-pic" class="related-pic">
            <h2>{{$info['title']}}的剧照</h2>
            <ul class="related-pic-bd narrow">
                @foreach($photos as $value)
                    <li>
                        <img src="/bridge/douban.html?url={{urlencode($value['src'])}}&id={{$id}}" alt="{{$info['title']}}剧照">
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('footer_script')
@endsection

