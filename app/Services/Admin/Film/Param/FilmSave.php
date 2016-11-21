<?php namespace App\Services\Admin\Film\Param;

use App\Services\Admin\AbstractParam;

/**
 * 电影操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class FilmSave extends AbstractParam
{
    protected $title;

    protected $summary;

    protected $content;

    protected $user_id;

    protected $site_id;

    protected $gather_url;

    protected $tags;

    protected $sources;

    protected $c_time;

    protected $status;

    protected $gather_action;
}
