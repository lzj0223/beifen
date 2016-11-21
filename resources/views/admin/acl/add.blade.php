<div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
      </button>
      <h3>
        <?php if(isset($id)): ?>
        修改功能信息
        <?php else:?>
        填写功能信息
        <?php endif; ?>
      </h3>
    </div>
    <div class="modal-body " style="height: auto">
      <div class="main-content">
        <div class="row">
          <div class="col-md-12">
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane active in" id="home">
                <form id="acl-add-form" class="form-horizontal" target="hiddenwin" method="post" action="{{$formUrl}}}" >
                  <div class="form-group input-group-sm">
                    <label class="col-sm-2 control-label">功能名：</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{$permissionInfo['name'] or ''}}" name="data[name]" class="form-control">
                    </div>
                  </div>
                  <div class="form-group input-group-sm">
                    <label class="col-sm-2 control-label">模块名：</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{$permissionInfo['module'] or ''}}" name="data[module]" class="form-control" placeholder="一般为子文件夹的名字。" >
                    </div>
                  </div>
                  <div class="form-group input-group-sm">
                    <label class="col-sm-2 control-label">类名：</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{$permissionInfo['class'] or ''}}" name="data[class]" class="form-control" placeholder="一般为Contrller的类名。" >
                    </div>
                  </div>
                  <div class="form-group input-group-sm">
                    <label class="col-sm-2 control-label">函数名：</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{$permissionInfo['action'] or ''}}" name="data[action]" class="form-control" placeholder="一般为Contrller的函数名。" >
                    </div>
                  </div>
                  <div class="form-group input-group-sm">
                    <label class="col-sm-2 control-label">父级：</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="data[pid]">
                        <option value="0">请选择父级功能</option>
                        <?php echo $select; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">备注：</label>
                    <div class="col-sm-10">
                      <textarea name="data[mark]" rows="3" class="form-control"><?php if(isset($permissionInfo['mark'])) echo $permissionInfo['mark']; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group input-group-sm">
                    <label class="col-sm-2 control-label">显示：</label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <input type="radio" id="genderm" <?php if(isset($permissionInfo['display']) && $permissionInfo['display'] == 1) echo 'checked="checked"'; ?> value="1" name="data[display]"> 是
                      </label>
                      <label class="radio-inline">
                        <input type="radio" id="genderf" <?php if(isset($permissionInfo['display']) && $permissionInfo['display'] == 0) echo 'checked="checked"'; ?> value="0" name="data[display]"> 否
                      </label>
                    </div>

                  </div>
                  <input name="data[id]" type="hidden" value="{{$id or ''}}" />
                </form>
              </div>
            </div>
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
    var  data = decodeURI($('#acl-add-form').serialize());
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