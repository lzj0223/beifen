<?php namespace App\Services\Admin\FilmSite\Param;

use App\Services\Admin\AbstractParam;

/**
 * 电影采集站点操作有关的参数容器，固定参数，方便分离处理。
 *
 */
class FilmSiteSave extends AbstractParam
{
    protected $id;

    protected $site_name;

    protected $site_url;

    protected $list_url;

    protected $list_reg;

    protected $content_reg;

    protected $page_reg;

    protected $charset;

    protected $status;
}
