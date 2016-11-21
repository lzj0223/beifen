@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-info btn-xs ajaxModal" data-url="<?php echo R('common', 'blog.category.add'); ?>" data-toggle="modal" data-target="#ajaxModal" type="button"><i class="fa fa-paste"></i> 新增分类</button>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>分类名字</th>
                        <th>状态</th>
                        <th>文章数</th>
                        <th>增加时间</th>
                        <th width="80">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><a target="_self" href="<?php echo R('common', 'blog.content.index', ['classify' => $value['id']]); ?>"><?php echo $value['name']; ?></a></td>
                        <td>
                            <?php echo $value['is_active'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                        </td>
                        <td><?php echo isset($value['articleNums']) ? $value['articleNums'] : 0; ?></td>
                        <td><?php echo date('Y-m-d H:i', $value['time']); ?></td>
                        <td>
                            <?php echo widget('Admin.Category')->edit($value); ?>
                            <?php echo widget('Admin.Category')->delete($value); ?>
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



