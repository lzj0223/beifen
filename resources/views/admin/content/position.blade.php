@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-info btn-xs ajaxModal" data-url="<?php echo R('common', 'blog.position.add'); ?>" data-toggle="modal" data-target="#ajaxModal" type="button"><i class="fa fa-paste"></i> 新增推荐位</button>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>推荐位名</th>
                        <th>状态</th>
                        <th>增加时间</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><?php echo $value['name']; ?></td>
                        <td>
                            <?php echo $value['is_active'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                        </td>
                        <td><?php echo date('Y-m-d H:i', $value['time']); ?></td>
                        <td>
                            <?php echo widget('Admin.Position')->relation($value); ?>
                            <?php echo widget('Admin.Position')->edit($value); ?>
                            <?php echo widget('Admin.Position')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php echo $page; ?>
            </div>

        </div>
    </div>
@endsection



