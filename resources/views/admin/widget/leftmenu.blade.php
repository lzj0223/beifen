<?php
$mcaName = \App\Services\Admin\MCAManager::MAC_BIND_NAME;
$MCA = app()->make($mcaName);
$lessThenThree = count($menu) <= 3 ? true : false;
?>

<?php foreach($menu as $key => $value): ?>
<li>
    <?php $son = App\Services\Admin\Tree::getSonKey();?>
    <?php if(isset($value[$son])): ?>
    <?php $checkFirst = $MCA->matchFirstMenu($value['module'], $value['class'], $value['action']); ?>
    <a href="#">
        <i class="fa fa-home"></i>
        <span class="nav-label"><?php echo $value['name']; ?></span>
        <span class="fa arrow"></span>
    </a>
    <?php if(is_array($value[$son]) && !empty($value[$son])): ?>
    <ul class="nav nav-second-level">
        <?php foreach($value[$son] as $skey => $svalue): ?>
        <?php $checkSecond = $MCA->matchSecondMenu($svalue['module'], $svalue['class'], $svalue['action']); ?>
        <?php $url = R('common', $svalue['module'] .'.'. $svalue['class'] .'.'. $svalue['action']); ?>
        <?php if(isset($svalue[$son]) && is_array($svalue[$son]) && !empty($svalue[$son])): ?>
                     <?php $randomThreeMenu = current($svalue[$son]); ?>
                     <?php $url = R('common', $randomThreeMenu['module'] .'.'. $randomThreeMenu['class'] .'.'. $randomThreeMenu['action']); ?>
        <?php endif; ?>

        <li>
            <a class="J_menuItem" href="<?php echo $url; ?>" data-index="0"><?php echo $svalue['name']; ?></a>
        </li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>

    <?php else: ?>
    <a class="J_menuItem" href="#"><i class="fa fa-magic"></i>
        <span class="nav-label"><?php echo $value['name']; ?></span></a>
    <?php endif;?>
</li>
<?php endforeach;?>
