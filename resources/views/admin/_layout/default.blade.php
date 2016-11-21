<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/mailbox.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 23 Oct 2015 09:10:41 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('seo_title')</title>
    <meta name="keywords" content="@yield('seo_keywords')">
    <meta name="description" content="@yield('seo_dsp')">
    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/font-awesome.min.css" rel="stylesheet">
    <link href="/static/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/static/css/animate.min.css" rel="stylesheet">
    <link href="/static/css/style.min.css" rel="stylesheet"><base target="_blank">
    @yield('header_css')
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content">
        @yield('content')
    </div>
    <div id="ajaxModal" class="modal" role="dialog" aria-hidden="true" tabindex="-1"></div>
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/content.min.js"></script>
    <script src="/static/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/static/js/plugins/layer/layer.js"></script>
    <script>
        $(document).ready(function(){
            $(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",});
            $('.content-menu-button').click(function(){
                var nav_href = $(this).attr('data-href');
                if(nav_href){
                    layer.load();
                    window.location.href = nav_href;
                }
            });

            $('.ajaxModal').click(function(){
                var url =  $(this).data('url') || $(this).attr('href');
                var ajaxModalId = $(this).data('ajax-modal-id') || 'ajaxModal';
                console.log(url);
                ajaxModalId = '#' + ajaxModalId;
                $(ajaxModalId).on('hidden.bs.modal', function (e) {
                    if($(ajaxModalId).data('reload')){
                        window.location.reload();
                    }
                    $(ajaxModalId).html('');
                })
                layer.load();
                $(ajaxModalId).load(url);
            });

            $('.ajax-delect').click(function(){
                var tips = $(this).data('tips');
                var url =  $(this).data('url') || $(this).attr('href');
                layer.confirm(tips, {icon: 3}, function(index){
                    $.ajax({
                        type:'GET',
                        url:url,
                        dataType: 'json',
                        success:  function(data) {
                            if(data.result) {
                                layer.msg(data.msg);
                                window.location.reload();
                            } else {
                                layer.msg(data.msg,{icon:2});
                            }
                        },
                        beforeSend: function() {
                            layer.load();
                        },
                        complete: function() {
                           layer.closeAll('loading');
                        }
                    });
                    layer.close(index);
                });
                return false;
            });

            $('.ajax-form').submit(function(){
                var url =  $(this).attr('action') || $(this).data('url') || $(this).attr('href');
                var method = $(this).attr('method') || $(this).data('method');
                var  data = decodeURI($(this).serialize());
                $.ajax({
                    type:method,
                    url:url,
                    dataType: 'json',
                    data:data,
                    success:  function(data) {
                        if(data.result) {
                            layer.msg(data.msg);
                            window.location.reload();
                        } else {
                            layer.msg(data.msg,{icon:2});
                        }
                    },
                    beforeSend: function() {
                        layer.load();
                    },
                    complete: function() {
                        layer.closeAll('loading');
                    }
                });
                return false;
            });


            $('.layer-iframe').click(function(){
                var url = $(this).data('url') || $(this).attr('href');
                //弹出即全屏
                var index = layer.open({
                    type: 2,
                    content: url,
                    area: ['300px', '195px'],
                    maxmin: true,
                    end:function(){
                        window.location.reload();
                    }
                });
                layer.full(index);
                return false;
            });

            $('.select-delete').click(function(){
                var group = $(this).attr('data-group');
                var url = $(this).attr('data-url') || $(this).attr('href');
                var ids = [];
                $('.' + group + ':checked').each(function(i){
                    ids[i] = $(this).val();
                });
                if(ids.length < 1){
                    layer.msg('请至少选择一项',{icon:5});
                    return false;
                }

                $.ajax({
                    type:'post',
                    url:url,
                    dataType: 'json',
                    data:{id:ids},
                    success:  function(data) {
                        if(data.result) {
                            layer.msg(data.msg);
                            window.location.reload();
                        } else {
                            layer.msg(data.msg,{icon:2});
                        }
                    },
                    beforeSend: function() {
                        layer.load();
                    },
                    complete: function() {
                        layer.closeAll('loading');
                    }
                });
                return false;
            });
        });
    </script>
    @yield('footer_script')
</body>

</html>