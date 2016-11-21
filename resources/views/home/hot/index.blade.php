@extends('home._layout.default')
@section('header_css')
    <style>

    </style>
    <link rel="stylesheet" href="css/new_css20160428.css">
@endsection
@section('content')
<div class="hotline_content_box row" >
    <div class="col-lg-12" style="clear: both;margin: 0 auto;float: none;padding: 10px 55px;">
        <div id="gaia" class="mb40">
            <div class="fliter-wp">
                <div class="filter">
                    <form action="/hot.html" id="gaia_frm" autocomplete="off">
                        <input name="type" value="movie" type="hidden">
                        <div class="tags">
                            <div class="tag-list">
                                <label @if($tag=='热门')class="activate"@endif>
                                    热门<input @if($tag=='热门')checked="checked"@endif name="tag" value="热门" type="radio">
                                </label>
                                <label @if($tag=='最新')class="activate"@endif>
                                    最新<input name="tag" value="最新" type="radio" @if($tag=='最新')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='经典')class="activate"@endif>
                                    经典<input name="tag" value="经典" type="radio" @if($tag=='经典')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='豆瓣高分')class="activate"@endif>
                                    豆瓣高分<input name="tag" value="豆瓣高分" type="radio" @if($tag=='豆瓣高分')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='冷门佳片')class="activate"@endif>
                                    冷门佳片 <input name="tag" value="冷门佳片" type="radio" @if($tag=='冷门佳片')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='华语')class="activate"@endif>
                                    华语 <input name="tag" value="华语" type="radio" @if($tag=='华语')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='欧美')class="activate"@endif>
                                    欧美 <input name="tag" value="欧美" type="radio" @if($tag=='欧美')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='韩国')class="activate"@endif>
                                    韩国 <input name="tag" value="韩国" type="radio" @if($tag=='韩国')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='日本')class="activate"@endif>
                                    日本 <input name="tag" value="日本" type="radio" @if($tag=='日本')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='动作')class="activate"@endif>
                                    动作 <input name="tag" value="动作" type="radio" @if($tag=='动作')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='喜剧')class="activate"@endif>
                                    喜剧 <input name="tag" value="喜剧" type="radio" @if($tag=='喜剧')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='爱情')class="activate"@endif>
                                    爱情 <input name="tag" value="爱情" type="radio" @if($tag=='爱情')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='科幻')class="activate"@endif>
                                    科幻 <input name="tag" value="科幻" type="radio" @if($tag=='科幻')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='悬疑')class="activate"@endif>
                                    悬疑 <input name="tag" value="悬疑" type="radio" @if($tag=='悬疑')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='恐怖')class="activate"@endif>
                                    恐怖 <input name="tag" value="恐怖" type="radio" @if($tag=='恐怖')checked="checked"@endif/>
                                </label>
                                <label @if($tag=='文艺')class="activate"@endif>
                                    文艺 <input name="tag" value="文艺" type="radio" @if($tag=='文艺')checked="checked"@endif/>
                                </label>
                            </div>
                            <div class="custom-frm" data-type="tag">
                                <input type="text">
                                <button>确定</button>
                            </div>
                        </div>

                        <div class="sub-tags">
                            <p class="tip">在 “<strong>热门</strong>” 里进一步筛选：</p>
                            <div class="sub-tag-list"></div>
                            <div class="custom-frm" data-type="sub_tag">
                                <input type="text">
                                <button>确定</button>
                            </div>
                        </div>

                        <div class="tool">
                            <div class="sort">
                                <label> <input name="sort" @if($sort=='recommend')checked="checked"@endif value="recommend"  type="radio" />按热度排序 </label>
                                <label> <input name="sort" @if($sort=='time')checked="checked"@endif  value="time" type="radio" />按时间排序 </label>
                                <label> <input name="sort" @if($sort=='rank')checked="checked"@endif  value="rank" type="radio" />按评价排序 </label>
                            </div>
                            <input name="page_limit" value="20" type="hidden" />
                            <input name="start" value="0" type="hidden" />
                        </div>
                    </form>
                </div>
            </div>

            <div class="list-wp">
                <div class="list" id="movies-list">
                    @foreach($hots as $key=>$value)
                    <a class="item" target="_blank" href="hot/detail.html?id={{$value['id']}}">
                        <div class="cover-wp" data-isnew="false" data-id="{{$value['id']}}">
                            <img src="{{$value['cover']}}" alt="{{$value['title']}}"/>
                        </div>
                        <p>
                            @if($value['is_new'])
                            <span class="green"> <img src="/images/ic_new.png" class="new" width="16" /> </span>
                            @endif
                            {{$value['title']}} <strong>{{$value['rate']}}</strong>
                        </p>
                    </a>
                    @endforeach
                </div>
                <a class="more" href="javascript:void (0);">加载更多</a>
            </div>
        </div>

        <div class="aside" style="background-color: #fff;">
            <div id="billboard" class="s" data-dstat-areaid="75" data-dstat-mode="click,expose">
                <div class="billboard-hd">
                    <h2>本周口碑榜</h2>
                </div>
                <div class="billboard-bd">
                    <table>
                        <tbody>
                        @foreach($rank as $value)
                            <tr>
                                <td class="order">{{$value['order']}}</td>
                                <td class="title"><a href="/hot/detail.html?id={{$value['id']}}" title="{{$value['title']}}">{{$value['title']}}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_script')
<script>
    $('.tag-list > label').click(function () {
        $('.tag-list > label').removeClass('activate');
        $(this).addClass('activate');
        $(this).children('input').attr('checked',true);
        $('#gaia_frm').submit();
    });

    $('[name="sort" ]').click(function () {
        $('#gaia_frm').submit();
    });

    $('.more').click(function () {
        $('[name="start"]').val($('.list > a.item').length);
        $.ajax({
            type:'get',
            url:'/hot/mlist.html',
            dataType: 'json',
            data:$('#gaia_frm').serialize(),//{start:start,tag:tag,sort:sort},
            success:  function(data) {
                if(data.msg == 'success') {
                    var html = '';
                    if (data.result && data.result.length > 0){
                        $.each(data.result,function () {
                            html += '<a class="item" target="_blank" href="hot/detail.html?id='+ this.id+'">'+
                                    '<div class="cover-wp" data-isnew="false" data-id="'+this.id+'">'+
                                    '<img src="'+this.cover+'" alt="'+ this.title +'"/></div><p>';
                            if(this.is_new){
                                html += '<span class="green"> <img src="/images/ic_new.png" class="new" width="16" /> </span>';
                            }
                            html += this.title+' <strong>'+this.rate+'</strong></p></a>';
                        });
                        $('#movies-list').append(html);
                    }else {
                        $('.more').text('没有了');
                        setTimeout(function () {
                            $('.more').remove();
                        },5);
                    }
                }else {
                    alert('网络错误！');
                }
            },
            beforeSend: function() {
                layer.load();
            },
            complete: function() {
                layer.closeAll('loading');
            }
        });
    });
</script>

@endsection

