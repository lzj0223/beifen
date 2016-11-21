<div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
            </button>
            <h3>
                <?php if(isset($id)): ?>
                修改用户信息
                <?php else:?>
                新增用户
                <?php endif; ?>
            </h3>
        </div>
        <div class="modal-body " style="height: auto">
            <form class="form-horizontal" method="post" action="{{$formUrl}}" id="user-info-form">
                <div class="alert alert-danger" style="display: none" id="tips">

                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">用户名：</label>
                    <div class="col-sm-9">
                        <input type="text" name="data[name]" id="username"  class="form-control" placeholder="用户名"
                               <?php if(isset($id)) echo 'disabled';?> value="{{$userInfo['name'] or ''}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">用户组：</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="data[group_id]" id="roleid" required="">
                            <?php foreach($groupList as $key => $value): ?>
                            <option value="{{$value['id']}}" <?php if(isset($userInfo['group_id']) && $userInfo['group_id'] == $value['id']) echo 'selected'; ?> >{{$value['group_name']}}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">手机号：</label>
                    <div class="col-sm-9">
                        <input type="text" name="data[mobile]" id="mobile"  class="form-control" value="{{$userInfo['mobile']  or ''}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">密 码：</label>
                    <div class="col-sm-9">
                        <input type="password" name="data[password]" id="password"  class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">真实姓名：</label>
                    <div class="col-sm-9">
                        <input type="text" name="data[realname]" id="realname"  class="form-control" value="{{$userInfo['realname']  or ''}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">备 注：</label>
                    <div class="col-sm-9">
                        <textarea name="data[mark]" id="mark" rows="3" class="form-control">{{$userInfo['mark']  or ''}}</textarea>
                    </div>
                </div>

                <?php if(isset($id)): ?>
                <input name="data[id]" type="hidden" value="<?php echo $id;?>" />
                <?php endif; ?>
            </form>
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
        var  data = decodeURI($('#user-info-form').serialize());
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

