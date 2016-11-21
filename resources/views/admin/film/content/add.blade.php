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
                                    <form target="_self" method="post" action="{{$formUrl}}" class="ajax-form col-md-8 ">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标题：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$info['title'] or ''}}" name="data[title]" class="form-control" placeholder="请填写电影标题">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">摘要：</label>
                                            <div class="col-sm-10">
                                                <textarea  placeholder="请填写电影摘要,摘要不超过200个字,超过时程序会自动裁剪保存" name="data[summary]" rows="3" class="form-control">{{$info['summary'] or ''}}</textarea>
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标签：</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="<?php if(isset($info['tagsInfo'])) echo implode(';', $info['tagsInfo']); ?>" name="data[tags]" class="form-control" placeholder="标签与标签之间请用“;”符号隔开。例如：PHP;LAMP">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">资源：</label>
                                            <div class="col-sm-10">
                                                @if (isset($info['sources']))
                                                    @foreach ($info['sources'] as $source)
                                                        <input type="text" value="{{$source['link']}}" name="data[sources][]" class="form-control sources mt" placeholder="电影资源链接,删除放空即可">
                                                    @endforeach
                                                @else
                                                    <input type="text" value="" name="data[sources][]" class="col-md-2 form-control mt sources" placeholder="电影资源链接,删除放空即可">
                                                @endif
                                                    <input type="text" value="" name="data[sources][]" class="col-md-2 form-control mt sources" placeholder="电影资源链接,删除放空即可">
                                                    <button id="add-source-input" class="btn  btn-xs mt" type="button"><i class="fa fa-plus-square"></i>  再添加一个</button>
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">正文：</label>
                                            <div class="col-sm-10">
                                                <script id="container" name="data[content]" type="text/plain"><?php if(isset($info['content'])) echo $info['content']; ?></script>
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">源站点：</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="data[site_id]">
                                                    <option value="0">请选择来源站点</option>
                                                    @foreach ($filmSite as $site)
                                                        @if(isset($info['site_id'])&&($info['site_id'] == $site['id']))
                                                            <option selected value="{{$site['id']}}">{{$site['site_name']}}</option>
                                                        @else
                                                            <option value="{{$site['id']}}">{{$site['site_name']}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="help-block m-b-none">若无，请放空</span>
                                            </div>
                                        </div>
                                        <div class="form-group mt">
                                            <label class="col-sm-2 control-label">源链接：</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="data[gather_url]" value="{{$info['gather_url'] or ''}}" class="form-control" placeholder="若无，请放空">
                                                <span class="help-block m-b-none"></span>
                                            </div>
                                        </div>
                                        <div class="form-group mt">
                                            <label class="col-sm-2 control-label">是否发布：</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($info['status']) && $info['status'] == 1) echo 'checked="checked"'; ?> value="1" name="data[status]"> 是</label>
                                                <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($info['status']) && $info['status'] == 0) echo 'checked="checked"'; ?> value="0" name="data[status]"> 否</label>
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
<script src="/lib/ueditor/ueditor.config.js" type="text/javascript"></script>
<script src="/lib/ueditor/ueditor.all.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'没有找到！'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    var ue = UE.getEditor('container', {
        autoHeight: false,
        initialFrameHeight: 500,
        autoFloatEnabled: true
    });

    $(document).keydown(function(e){
        // ctrl + s
        if( e.ctrlKey  == true && e.keyCode == 83 ){
            $('#save-buttom').trigger('click');
            return false; // 截取返回false就不会保存网页了
        }
    });
    $('#add-source-input').click(function(){
        $('.sources:last').after('<input type="text" value="" name="data[sources][]" class="col-md-2 form-control mt" placeholder="电影资源链接,删除放空即可">')
    });
</script>
@endsection