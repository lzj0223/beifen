@extends('admin._layout.default')

@section('content')
    <style>
        .ajax-form label{text-align: right;padding-right: 0px;}
        .ajax-form .form-group{margin-top: 10px}
        .mt{margin-top: 8px}
    </style>
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="main-content">
                <div id="sys-list">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="myTabContent" class="tab-content row">
                                <div class="tab-pane active in" id="home">
                                    <form target="_self" method="post" action="{{$formUrl}}" class="hot-form col-md-8 ">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标题：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$info['title'] or ''}}" name="data[title]" class="form-control" placeholder="请填写电影标题">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">简介：</label>
                                            <div class="col-sm-10">
                                                <textarea  placeholder="请填写电影简介,简介不超过500个字,超过时程序会自动裁剪保存" name="data[summary]" rows="3" class="form-control">{{$info['summary'] or ''}}</textarea>
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">导演：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$info['director']  or ''}}" name="data[director]" class="form-control" placeholder="电影导演">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">编剧：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$info['screenwriter'] or ''}}" name="data[screenwriter]" class="form-control" placeholder="电影编剧">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">主演：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$info['main_performer'] or ''}}" name="data[main_performer]" class="form-control" placeholder="主演">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">片长：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$info['long'] or ''}}" name="data[long]" class="form-control" placeholder="片长">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">国家/地区：</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="test_data" name="data[country]" value="{{$info['country_name'] or ''}}" >
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                </div>
                                                <span class="help-block m-b-none">

                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">上映时间：</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="show-time" value="{{$info['show_time'] or ''}}" name="data[show_time]" class="form-control" placeholder="电影上映时间">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">电影封面：</label>
                                            <div class="col-sm-10">
                                                <div id="file-pretty">
                                                    <input type="file" class="form-control" name="thumb">
                                                </div>
                                                <span class="help-block m-b-none preview" >
                                                    @if(isset($info['thumb']))
                                                        <img width="180" height="180" src="{{$info['thumb']}}" />
                                                    @endif
                                                </span>
                                            </div>
                                        </div>


                                        <div class="btn-toolbar list-toolbar">
                                            <button id="save-buttom" class="btn btn-primary btn-sm" type="submit"><i class="fa fa-save"></i> 保存</button>
                                            <button onclick="parent.layer.closeAll()" class="btn  btn-sm" type="button"><i class="fa fa-close"></i> 取消</button>
                                        </div>
                                        <input name="id" type="hidden" value="{{$id or ''}}" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer_script')
<link rel="stylesheet" type="text/css" href="/lib/chosen/min.css">
<script src="/lib/chosen/min.js" type="text/javascript"></script>
<link href="/static/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script src="/static/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/static/js/plugins/suggest/bootstrap-suggest.min.js"></script>
<script src="/static/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
<script src="/static/js/plugins/jqueryForm/jquery-form.js"></script>
<script type="text/javascript">
    $(document).keydown(function(e){
        // ctrl + s
        if( e.ctrlKey  == true && e.keyCode == 83 ){
            $('#save-buttom').trigger('click');
            return false; // 截取返回false就不会保存网页了
        }
    });
    $("#show-time").datepicker({todayBtn:"linked",keyboardNavigation:!1,forceParse:!1,calendarWeeks:!0,autoclose:!0})
    $('#file-pretty input[type="file"]').prettyFile();

    function preview(file) {
        var img = new Image(), url = img.src = URL.createObjectURL(file);
        img.width='180';
        img.height='180';
        var $img = $(img);
        $('#thumb').val(url);
        img.onload = function() {
            URL.revokeObjectURL(url)
            $('.preview img').remove();
            $img.appendTo($('.preview'))
            //$('#preview'+id).show();
        }
    }
    $(function() {
        $('[type=file]').change(function(e) {
            var file = e.target.files[0]
            preview(file)
        })
    });
    $(".hot-form").submit(function(){
        $(".hot-form").ajaxSubmit({
            dataType:  'json', //数据格式为json
            beforeSubmit:function(){
                layer.load();
            },
            success: function(data) { //成功
                //获得后台返回的json数据
                if(data.result) {
                    layer.msg(data.msg,function(){
                        parent.layer.closeAll();
                    });
                } else {
                    layer.msg(data.msg,{icon:2});
                }
                layer.closeAll('loading');
            },
            error:function(xhr){ //上传失败
                layer.msg('请求失败',{icon:2});
                layer.closeAll('loading');
            }
        });
        return false;
    });
    $(function(){
        var testdataBsSuggest=$("#test_data").bsSuggest({
            indexId:0,
            indexKey:0,
            data:{
                "value":{!! json_encode($countrys) !!},
            },
        });
    });

</script>
@endsection