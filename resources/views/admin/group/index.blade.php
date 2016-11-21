@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-10 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-info btn-xs ajaxModal" data-target="#ajaxModal" data-url="<?php echo R('common', 'foundation.group.add'); ?>" data-toggle="modal" type="button"><i class="fa fa-paste"></i> 新增用户组</button>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">

                <table class="table table-hover table-mail">
                    <thead>
                    <tr>
                        <th>用户组名</th>
                        <th>备注</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($grouplist as $key => $value): ?>
                    <tr>
                        <td><?php echo $value['group_name']; ?></td>
                        <td><?php echo $value['mark']; ?></td>
                        <td><?php echo $value['status'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?></td>
                        <td>
                            <?php echo widget('Admin.Group')->edit($value); ?>
                            <?php echo widget('Admin.Group')->acl($value); ?>
                            <?php echo widget('Admin.Group')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center" style="clear: both"><?php echo $page; ?></div>
            </div>
        </div>
    </div>
@endsection
