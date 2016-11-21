@extends('mobile._layout.default')


@section('header_css')
    <style>
        .infinite-scroll-preloader {
            margin-top:-20px;
        }
        .card-header{justify-content: flex-start;display: block;}
        .highlight{color: red}
        a{color: #3d4145}
    </style>
@endsection

@section('content')
    <div class="bar bar-nav">
        <div class="searchbar">
            <a class="searchbar-cancel">取消</a>
            <form class="search-input">
                <label class="icon icon-search" for="search"></label>
                <input type="search" id='search' name="search" placeholder='输入关键字...' value="{{$keyword}}"/>
            </form>
        </div>
    </div>

   <div style="margin-top: 2.5rem" class="infinite-scroll infinite-scroll-bottom" data-distance="100">
       <div class="list-block">
           <div class="list-container">
               @foreach($films as $value)
                   <a href="/{{$value['id']}}.html" class="ajax_detail">
                       <div class="card">
                           <div class="card-header">
                               {!!$value['title']!!}
                           </div>
                           <div class="card-content">
                               <div class="card-content-inner"> {!!$value['summary']!!}</div>
                           </div>
                           <div class="card-footer">
                               <div class="add-time"> {{$value['c_time']}}</div>
                               <div class="source">{{$value['site']}}</div>
                           </div>
                       </div>
                   </a>
               @endforeach
           </div>
       </div>

       <!-- 加载提示符 -->
       <div class="infinite-scroll-preloader">
           <div class="preloader"></div>
       </div>
   </div>
@endsection


@section('footer_script')
<script>
    $(function () {
        'use strict';
        //无限滚动
        $(document).on("pageInit", "#page-infinite-scroll-bottom", function(e, id, page) {
            var loading = false;
            // 每次加载添加多少条目
            var itemsPerLoad = $('.list-container div.card').length;
            // 最多可加载的条目
            var maxItems = {{$total or 0}};
            var lastIndex = itemsPerLoad;// = $('.list-container div.card').length;

            function addItems(data){
                if (lastIndex >= maxItems) {
                    // 加载完毕，则注销无限加载事件，以防不必要的加载
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    // 删除加载提示符
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                $.getJSON('/index/get_list.html',data,function(res){
                    if(res.msg == 'success'){
                        var html = '';
                        $.each(res.data.items,function(){
                            html += '<a href="/'+this.id+'.html"><div class="card"><div class="card-header">'+this.title+'</div><div class="card-content">'+
                            '<div class="card-content-inner">'+this.summary+'</div></div>'+
                            '<div class="card-footer"><div class="add-time">'+this.c_time+'</div>' +
                            '<div class="source">'+ this.site +'</div></div></div></a>';
                        });
                        // 添加新条目
                        $('.infinite-scroll .list-container').append(html);
                        // 更新最后加载的序号
                        lastIndex = $('.list-container div.card').length;
                        loading = false;
                        $.refreshScroller();
                        $('.ajax_detail').on('click',function(){
                            $.router.load($(this).attr('href'));
                            return false;
                        });
                    }
                });
            }
            $(page).on('infinite', function() {
                // 如果正在加载，则退出
                if (loading) return;
                // 设置flag
                loading = true;
                var curr_page = lastIndex > 1 ? Math.ceil(lastIndex/itemsPerLoad) : 2;
                var search = $('#search').val();
                addItems({page:Math.ceil(lastIndex/itemsPerLoad)+1,limit:itemsPerLoad,search:search});
            });
            $('.ajax_detail').on('click',function(){
                $.router.load($(this).attr('href'));
                return false;
            });
        });

        $.init();
    });
</script>
@endsection

