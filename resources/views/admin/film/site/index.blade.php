@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <?php echo widget('Admin.FilmSite')->add(); ?>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>

                </div>
            </div>
            <div class="mail-box">
                <table class="table table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th>网站名称</th>
                        <th>网址</th>
                        <th>电影数</th>
                        <th>状态</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="select-delete-group" value="{{$value['id']}}"></td>
                        <td>{{$value['site_name']}}</td>
                        <td>{{$value['site_url']}}</td>
                        <td><?php echo isset($value['filmNum']) ? $value['filmNum'] : 0; ?></td>
                        <td><?php echo isset($value['status'])&&$value['status']==1  ? '激活' : '未激活'; ?></td>
                        <td>
                            <?php echo widget('Admin.FilmSite')->edit($value); ?>
                            <?php echo widget('Admin.FilmSite')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7">
                            <?php echo widget('Admin.FilmSite')->deleteSelect(); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" style="clear: both"><?php echo $page; ?></div>
            </div>
        </div>
    </div>
@endsection



