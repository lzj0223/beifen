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
                        <?php echo widget('Admin.FilmHot')->add(); ?>
                    </div>
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th width="50%">标题</th>
                        <th>上映时间</th>
                        <th>添加时间</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if( ! empty($list)): ?>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="select-delete-group" value="{{$value['id']}}"></td>
                        <td><a target="_blank" href="{{route('home', ['class' => 'hot', 'action' => 'detail', 'id' => $value['id']])}}">{{$value['title']}}</a></td>
                        <td>{{$value['show_time']}}</td>
                        <td>{{$value['c_time']}}</td>
                        <td>
                            <?php echo widget('Admin.FilmHot')->edit($value); ?>
                            <?php echo widget('Admin.FilmHot')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                            <tr>
                                <td colspan="7">
                                    <?php echo widget('Admin.FilmHot')->deleteSelect(); ?>
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



    </script>
@endsection



