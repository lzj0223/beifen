<?php namespace App\Services\Admin\FilmHot\Param;

use App\Services\Admin\AbstractParam;

/**
 * 电影操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class FilmHotSave extends AbstractParam
{
    protected $title;

    protected $summary;

    protected $director;

    protected $user_id;

    protected $thumb;

    protected $screenwriter;

    protected $country;

    protected $show_time;

    protected $long;

    protected $status;

    protected $sort;

    protected $c_time;

    protected $main_performer;
}
