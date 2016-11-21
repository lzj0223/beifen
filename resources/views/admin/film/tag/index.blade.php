@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">
                <table class="table table-bordered table-striped" style="margin: 0 auto;width: 80%" >
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th>标签名</th>
                        <th>电影数</th>
                        <th>点击数</th>
                        <th>状态</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="select-delete-group" value="{{$value['id']}}"></td>
                        <td>{{$value['tag']}}</td>
                        <td><?php echo isset($value['filmNums']) ? $value['filmNums'] : 0; ?></td>
                        <td>{{$value['clikcs']}}</td>
                        <td>{{$value['status']}}</td>
                        <td>
                            <?php echo widget('Admin.FilmTag')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7">
                            <?php echo widget('Admin.FilmTag')->deleteSelect(); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" style="clear: both"><?php echo $page; ?></div>
            </div>
        </div>
    </div>
@endsection



