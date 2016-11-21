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
                        <?php echo widget('Admin.FilmContent')->add(); ?>
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
                            <label for="search-siteid">来源站点:</label>
                            <select class="form-control" name="site_id" id="search-siteid">
                                <option value="0">请选择来源站点</option>
                                @foreach ($filmSite as $site)
                                    @if(isset($search['site_id'])&&($search['site_id'] == $site['id']))
                                        <option selected value="{{$site['id']}}">{{$site['site_name']}}</option>
                                    @else
                                        <option value="{{$site['id']}}">{{$site['site_name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
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
                        <th>添加时间</th>
                        <th>状态</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if( ! empty($list)): ?>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="select-delete-group" value="{{$value['id']}}"></td>
                        <td><a target="_blank" href="{{route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']])}}">{{$value['title']}}</a></td>
                        <td>{{$value['c_time']}}</td>
                        <td>
                            <?php echo $value['status'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                        </td>
                        <td>
                            <?php echo widget('Admin.FilmContent')->edit($value); ?>
                            <?php echo widget('Admin.FilmContent')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                            <tr>
                                <td colspan="7">
                                    <?php echo widget('Admin.FilmContent')->deleteSelect(); ?>
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



