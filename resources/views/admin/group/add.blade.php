<div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
      </button>
      <h3>
        <?php if(isset($id)): ?>
        修改用户组信息
        <?php else:?>
        填写用户组信息
        <?php endif; ?>
      </h3>
    </div>
    <div class="modal-body " style="height: auto">
      <div class="main-content">
        <div class="row">
          <div class="col-md-12">
            <form id="group-add-form" class=""  method="post" action="<?php echo $formUrl; ?>">
              <div class="form-group input-group-sm">
                <label>用户组名：</label>
                <input type="text" value="{{$groupInfo['group_name'] or ''}}" name="data[group_name]" class="form-control">
              </div>
              <div class="form-group input-group-sm">
                <label>用户组等级：</label>
                <input type="text" value="{{$groupInfo['level'] or ''}}" name="data[level]" class="form-control" placeholder="请输入数字，数字越大，等级越小。" >
              </div>
              <div class="form-group">
                <label>备注：</label>
                <textarea name="data[mark]" rows="3" class="form-control">{{$groupInfo['mark'] or ''}}</textarea>
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
    var  data = decodeURI($('#group-add-form').serialize());
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