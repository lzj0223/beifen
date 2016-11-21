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
                        <th>分类名字</th>
                        <th>文章数</th>
                        <th width="70">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><a href="{{R('common', 'blog.content.index', ['tag' => $value['id']])}}">{{$value['name']}}</a></td>
                        <td><?php echo isset($value['articleNums']) ? $value['articleNums'] : 0; ?></td>
                        <td>
                            <?php echo widget('Admin.Tags')->delete($value); ?>
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



