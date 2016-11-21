<div style="min-width: 360px; overflow-y:auto;">
  <table class="table table-bordered table-striped table-condensed">
    <tr>
        <?php $tmp = 1; $perNums = 4; ?>
        <?php $count = count($list); ?>
        <?php $m = $count % $perNums; ?>
        <?php $list = array_pad($list, $count + ($perNums - $m), [])?>
        <?php foreach($list as $key => $value): ?>
            <td width="25%">
                <?php if(isset($value['name'])): ?>
                    <label class="checkbox-inline">
                        <input class="pl-position-id" type="checkbox" value="{{$value['id']}}" >{{$value['name']}}
                    </label>
                <?php endif; ?>
            </td>
            <?php if($tmp % $perNums == 0): ?>
                </tr><tr>
            <?php endif; ?>
            <?php $tmp++; ?>
        <?php endforeach; ?>
  </table>
</div>