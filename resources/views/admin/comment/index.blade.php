@extends('admin._layout.default')

@section('content')
    <div class="row">
        <div class="col-sm-10 animated fadeInRight">
            <div class="mail-box-header">
                <div class="mail-tools tooltip-demo m-t-md">
                    <?php echo widget('Admin.Menu')->contentMenu(); ?>
                </div>
            </div>
            <div class="mail-box">

                <table class="table table-hover table-mail">
                    <thead>
                    <tr>
                        <th width="70">选择</th>
                        <th>评论内容</th>
                        <th width="80">所属文章</th>
                        <th width="100">评论人</th>
                        <th width="150">评论时间</th>
                        <th width="80">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="{{$value['id']}}"></td>
                        <td>{{$value['content']}}</td>
                        <td><a target="_blank" href="{{route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['object_id']])}}"><?php echo '查看'; ?></a></td>
                        <td><?php echo $value['nickname'] == '__blog.author__' ? '<span style="color:red;">博主</span>' : $value['nickname']; ?></td>
                        <td>{{date('Y-m-d H:i', $value['time'])}}</td>
                        <td>
                            <?php $result = widget('Admin.Comment')->reply($value); echo $result['html']; ?>
                            <?php echo widget('Admin.Comment')->delete($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center" style="clear: both"><?php echo $page; ?></div>
        </div>
    </div>
@endsection
