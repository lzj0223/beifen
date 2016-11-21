@extends('admin._layout.default')

@section('content')
    <style>
        .pagination{height: 20px;margin: 0 auto;}
        .search-article{height: auto;line-height: 30px;margin: 0 50px 15px;}
    </style>
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-info btn-xs layer-iframe" data-url="<?php echo R('common', 'blog.content.add'); ?>"  type="button"><i class="fa fa-paste"></i> 发布文章</button>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">
                <form method="get" action="" class="search-article" target="_self">
                    <div class="form-inline">
                        <div class="form-group input-group-sm f-g">
                            <label for="search-keyword">关键词:</label>
                            <input type="text" value="{{$search['keyword'] or ''}}" name="keyword" id="search-keyword" class="form-control" placeholder="请输入关键词" >
                        </div>

                        <div class="form-group input-group-sm f-g">
                            <label for="search-username">作者</label>
                            <select name="username" id="DropDownTimezone" class="form-control">
                                <option value="">请选择</option>
                                <?php if(isset($users) and is_array($users)): ?>
                                <?php foreach($users as $key => $value): ?>
                                <option value="<?php echo $value['id'];?>" <?php if(isset($search['username']) && $search['username'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </select>
                        </div>

                        <div class="form-group input-group-sm f-g">
                            <label for="search-classify">分类</label>
                            <select name="classify" id="DropDownTimezone" class="form-control">
                                <option value="">请选择</option>
                                <?php if(isset($classifyInfo) and is_array($classifyInfo)): ?>
                                <?php foreach($classifyInfo as $key => $value): ?>
                                <option value="<?php echo $value['id'];?>" <?php if(isset($search['classify']) && $search['classify'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </select>
                        </div>

                        <div class="form-group input-group-sm f-g">
                            <label for="search-position">推荐位</label>
                            <select name="position" id="DropDownTimezone" class="form-control zdy-form-select zdy-form-select-obj">
                                <option value="">请选择</option>
                                <?php if(isset($positionInfo) and is_array($positionInfo)): ?>
                                <?php foreach($positionInfo as $key => $value): ?>
                                <option value="<?php echo $value['id'];?>" <?php if(isset($search['position']) && $search['position'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </select>
                        </div>

                        <div class="form-group input-group-sm f-g">
                            <label for="search-tag">标签</label>
                            <select name="tag" id="DropDownTimezone" class="form-control">
                                <option value="">请选择</option>
                                <?php if(isset($tagInfo) and is_array($tagInfo)): ?>
                                <?php foreach($tagInfo as $key => $value): ?>
                                <option value="<?php echo $value['id'];?>" <?php if(isset($search['tag']) && $search['tag'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-inline">
                        <div class="form-group input-group-sm f-g">
                            <label for="search-time">时    间:</label>
                            <input type="text" value="{{$search['timeFrom'] or ''}}" name="time_from" id="search-time" class="form-control">
                            到
                            <input type="text" value="{{$search['timeTo'] or ''}}" name="time_to" id="search-time-to" class="form-control">
                        </div>
                        <div class="form-group btn-group-sm f-g">
                            <input class="btn  btn-primary" type="submit" value="查  询">
                        </div>
                    </div>
                </form>
            </div>
            <div class="mail-box">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th width="50%">标题</th>
                        <th>分类</th>
                        <th>作者</th>
                        <th>写作时间</th>
                        <th>状态</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if( ! empty($list)): ?>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="{{$value['id']}}"></td>
                        <td><a target="_blank" href="{{route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']])}}">{{$value['title']}}</a></td>
                        <td>{{$value['classnames']}}</td>
                        <td>{{$value['name']}}</td>
                        <td>{{date('Y-m-d H:i', $value['write_time'])}}</td>
                        <td>
                            <?php echo $value['status'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                        </td>
                        <td>
                            <?php echo widget('Admin.Content')->edit($value); ?>
                            <?php echo widget('Admin.Content')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                            <tr>
                                <td colspan="7">
                                    <?php echo $deleteSelectButton = widget('Admin.Content')->deleteSelect(); ?>
                                    <?php echo $positionButton = widget('Admin.Content')->position(); ?>
                                </td>
                            </tr>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr><td colspan="7" align="center"><?php echo $page; ?></td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div id="position-dialog-content" style="display: none">
        <?php echo widget('Admin.Content')->positionDialogContent(); ?>;
    </div>
@endsection
@section('footer_script')
        <!-- js css -->
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.css'); ?>">
    <script src="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/datepicker/locales/bootstrap-datetimepicker.zh-CN.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $('#search-time').datetimepicker({
            language:  'zh-CN',
            format: "yyyy-mm-dd hh:ii:ss",
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        });

        $('#search-time-to').datetimepicker({
            language:  'zh-CN',
            format: "yyyy-mm-dd hh:ii:ss",
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        });


        <?php if( ! empty($positionButton)): ?>
        $('.pl-position').click(function(){
                    var idsCheckBox = $(".ids:checked");
                    if(idsCheckBox.length < 1){
                        layer.msg('请先选择需要关联的文章', {icon: 5});
                        return false;
                    }
                    var ids = [];
                    $.each(idsCheckBox,function(i,v){
                        ids[i] = $(v).val();
                    });

                    layer.open({
                        title:"关联推荐位",
                        content: $('#position-dialog-content').html(),
                        btn: ['保存', '取消'], //可以无限个按钮
                        area: ['60%','auto'],
                        type: 1,
                        closeBtn: 1,
                        shadeClose: true,
                        yes: function(index, layero){
                            var positionIdObj = $(".pl-position-id:checked");
                            if(positionIdObj.length < 1){
                                layer.msg('请选择推荐位', {icon: 5});
                                return false;
                            }
                            var positionId = [];
                            $.each(positionIdObj,function(i,v){
                                positionId[i] = $(v).val();
                            });

                            $.ajax({
                                type:"post",
                                url:"{{R('common', 'blog.content.position')}}",
                                dataType: 'json',
                                data:{ids:ids,pids:positionId},
                                success:  function(data) {
                                    if(data.result) {
                                        layer.msg(data.msg);
                                        window.location.reload();
                                    } else {
                                        layer.msg(data.msg,{icon:5});
                                    }
                                },
                                beforeSend: function() {
                                    layer.load();
                                },
                                complete: function() {
                                    layer.closeAll('loading');
                                }
                            });
                           // return false;
                        }, cancel:function(index, layero){//按钮【按钮一】的回调
                            $(".pl-position-id:checked").each(function(){
                                $(this).attr("checked",false);
                            });
                        }
                    });
                });
        <?php endif; ?>
    </script>
@endsection



