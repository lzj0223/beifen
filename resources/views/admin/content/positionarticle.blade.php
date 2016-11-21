@extends('admin._layout.default')

@section('content')
    <style>
        .pagination{height: 20px;margin: 0 auto;}
        .search-article{height: auto;line-height: 30px;margin: 0 50px 15px;}
    </style>
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box">
                <form method="get" action="" class="search-article" target="_self">
                    <div class="form-inline">
                        <div class="form-group input-group-sm f-g">
                            <label for="search-position">推荐位</label>
                            <select name="position" id="search-position" class="form-control">
                                <option value="">请选择</option>
                                <?php if(isset($positionInfo) and is_array($positionInfo)): ?>
                                <?php foreach($positionInfo as $key => $value): ?>
                                <option value="<?php echo $value['id'];?>" <?php if(isset($positionId) && $positionId == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                                <?php endforeach; ?>
                                <?php endif;?>
                            </select>
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
                        <th width="60">选择</th>
                        <th width="70">排序</th>
                        <th>标题</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if( ! empty($list)): ?>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="{{$value['id']}}"></td>
                        <td><input type="text" class="pl-input-sort" data-prid="{{$value['id']}}" value="{{$value['sort']}}" style="width:50px;text-align:center;"></td>
                        <td><a target="_blank" href="{{route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['article_id']])}}">{{$value['title']}}</a></td>
                        <td>
                            <?php echo widget('Admin.Position')->deleteRelation($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7">
                            <?php echo $deleteSelectButton = widget('Admin.Position')->deleteSelectRelation(); ?>
                            <?php echo $relationSortButton = widget('Admin.Position')->relationSort(); ?>
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
        <?php if( ! empty($deleteSelectButton)): ?>
        $('.pl-delete').click(function() {
                    var idsObj = $('.ids:checked');
                    if(idsObj.length < 1){
                        layer.msg('请先选择需要取消关联的文章',{icon:5})
                        return false;
                    };
                    var ids = [];
                    idsObj.each(function(i,v){
                        ids[i] = $(v).val();
                    });
                    layer.confirm('确定取消关联吗？', {icon: 3, title:'提示'}, function(index){
                        $.ajax({
                            type:"post",
                            url:"{{R('common', 'blog.position.delrelation')}}",
                            dataType: 'json',
                            data:{prid:ids},
                            success:  function(data) {
                                if(data.result) {
                                    layer.msg(data.msg,{icon:6});
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
                    });
                });
        <?php endif; ?>
         <?php if( ! empty($relationSortButton)): ?>
        $('.pl-sort').click(function() {
                    var data = [];
                    var json;
                    $('.pl-input-sort').each(function(i, n){
                        json = {"prid": $(n).attr('data-prid'), "sort": $(n).val()};
                        data.push(json);
                    });
                    $.ajax({
                        type:"post",
                        url:"{{R('common', 'blog.position.sortrelation')}}",
                        dataType: 'json',
                        data:{data:data},
                        success:  function(data) {
                            if(data.result) {
                                layer.msg(data.msg,{icon:6});
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
                });
        <?php endif; ?>

    </script>
@endsection
