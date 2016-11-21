@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-info btn-xs ajaxModal" data-url="<?php echo R('common', 'foundation.acl.add'); ?>" data-toggle="modal" data-target="#ajaxModal" type="button"><i class="fa fa-paste"></i> 新增功能</button>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">
                <form class="ajax-form"  method="post" action="<?php echo R('common', 'foundation.acl.sort');?>">
                <table class="table table-hover table-mail">
                    <thead>
                    <tr>
                        <th>排序</th>
                        <th>功能名字</th>
                        <th>功能代码（-为分隔线）</th>
                        <th>显示为菜单?</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo widget('Admin.Acl')->acllist($list, $pid); ?>
                    </tbody>
                </table>
                <?php echo widget('Admin.Acl')->sort(); ?>
                </form>
            </div>

        </div>
    </div>
@endsection



