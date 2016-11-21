<div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
            </button>
            <h3>填写站点信息</h3>
        </div>
        <div class="modal-body " style="height: auto">
            <div class="main-content">
                <div class="row">
                    <div class="col-md-10">
                        <form id="add-form"  method="post" action="{{$formUrl}}" role="form" style="min-height: 65px;">
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">站点名字：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['site_name'] or ''}}" name="data[site_name]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">站点地址：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['site_url'] or ''}}" name="data[site_url]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">电影列表地址：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['list_url'] or ''}}" name="data[list_url]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">列表匹配规则：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['list_reg'] or ''}}" name="data[list_reg]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">分页匹配规则：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['page_reg'] or ''}}" name="data[page_reg]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">内容匹配规则：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['content_reg'] or ''}}" name="data[content_reg]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height: 30px;">
                                <label class="col-sm-4 control-label">采集程序：</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$info['gather_action'] or ''}}" name="data[gather_action]" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="form-group" style="min-height:30px;">
                                <label class="col-sm-4 control-label">是否激活：</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($info['status']) && $info['status'] == 1) echo 'checked="checked"'; ?> value="1" name="data[status]"> 是</label>
                                    <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($info['status']) && $info['status'] == 0) echo 'checked="checked"'; ?> value="0" name="data[status]"> 否</label>
                                </div>
                            </div>

                            <input name="data[id]" type="hidden" value="{{$id or ''}}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            <button type="button" class="btn btn-primary" id="save">保存</button>
        </div>
    </div>
</div>

<script>
    layer.closeAll('loading');

    $('#save').click(function(){
        var  data = decodeURI($('#add-form').serialize());
        $.ajax({
            url:'{{$formUrl}}',
            type:'post',
            dataType:'json',
            data:data,
            success:function(res){
                layer.closeAll();
                if(res.result){
                    layer.msg(res.msg,{icon: 1},function(){
                        window.location.reload();
                    });
                }else{
                    layer.msg(res.msg,{icon: 2});
                }
            },
            beforeSend: function() {
                layer.load();
                $('#save').attr('disabled',true);
                $('#save').text('提交中...');
            },
            timeout: 30000,
            complete: function(request, status) {
                if(status == 'timeout') {
                    layer.msg('网络链接超时，请重试！',{icon:2});
                }
                $('#save').attr('disabled',false);
                $('#save').text('保存');
            }
        });
    });
</script>