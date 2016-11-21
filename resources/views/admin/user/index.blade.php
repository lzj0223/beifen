@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-info btn-xs ajaxModal" data-url="<?php echo R('common', 'foundation.user.add'); ?>" data-toggle="modal" data-target="#ajaxModal" type="button"><i class="fa fa-paste"></i> 新增用户组</button>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">

                <table class="table table-hover table-mail">
                    <thead>
                    <tr>
                        <th>真实姓名</th>
                        <th>用户名</th>
                        <th>用户组</th>
                        <th>电话</th>
                        <th>最后登录</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($userList as $key => $value): ?>
                    <tr>
                        <td><?php echo $value['realname']; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['group_name']; ?></td>
                        <td><?php echo $value['mobile']; ?></td>
                        <td><?php echo date('Y-m-d H', $value['last_login_time']); ?></td>
                        <td>
                            <?php echo widget('Admin.User')->edit($value); ?>
                            <?php echo widget('Admin.User')->acl($value); ?>
                            <?php echo widget('Admin.User')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
