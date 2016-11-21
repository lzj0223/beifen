@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="main-content">
                <div id="sys-list">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane active in" id="home">
                                    <form target="hiddenwin" method="post" action="{{$formUrl}}" class="ajax-form">
                                        <div class="form-group input-group-sm">
                                            <label>标题</label>
                                            <input type="text" value="{{$info['title'] or ''}}" name="data[title]" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>简介</label>
                                            <textarea name="data[summary]" rows="3" class="form-control">{{$info['summary'] or ''}}</textarea>
                                        </div>
                                        <div class="form-group input-group-sm">
                                            <label>标签</label>
                                            <input type="text" value="<?php if(isset($info['tagsInfo'])) echo implode(';', $info['tagsInfo']); ?>" name="data[tags]" class="form-control" placeholder="标签与标签之间请用“;”符号隔开。例如：PHP;LAMP">
                                        </div>

                                        <div class="form-group input-group-sm">
                                            <label>类别</label><br/>
                                            <select data-placeholder="请选择分类" class="form-control chosen-select" multiple name="data[classify][]">
                                                <option value=""></option>
                                                <?php if(isset($classifyInfo) && is_array($classifyInfo)): ?>
                                                <?php foreach($classifyInfo as $key => $value): ?>
                                                <option value="{{$value['id']}}" <?php if(isset($info['classifyInfo']) and in_array($value['id'], $info['classifyInfo'])) echo 'selected'; ?> >{{$value['name']}}</option>;
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="form-group input-group-sm">
                                            <label>正文</label>
                                            <script id="container" name="data[content]" type="text/plain"><?php if(isset($info['content'])) echo $info['content']; ?></script>
                                        </div>

                                        <div class="form-group input-group-sm">
                                            <label>是否发布</label>
                                            <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($info['status']) && $info['status'] == 1) echo 'checked="checked"'; ?> value="1" name="data[status]"> 是</label>
                                            <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($info['status']) && $info['status'] == 0) echo 'checked="checked"'; ?> value="0" name="data[status]"> 否</label>
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
</script>
@endsection