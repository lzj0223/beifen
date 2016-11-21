<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 电影源站表模型
 *
 * @author jiang
 */
class FilmSite extends Base
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'film_site';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'site_name','gather_action', 'site_url', 'list_url','list_reg','content_reg','page_reg','charset','status');

    /**
     * 电影源站status状态
     */
    CONST IS_DELETE_NO = 0;

    /**
     * 电影源站status状态
     */
    CONST IS_DELETE_YES = -1;

    /**
     * 取得指定信息
     * 
     * @param string $tagName
     * @return array
     */
    public function getOneById($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * 更新
     */
    public function updateSite(array $data,$id)
    {
        return $this->where('id', $id)->update($data);
    }

    /**
     * 增加新站点
     */
    public function addSite($isertData)
    {
        return $this->create($isertData);
    }

    /**
     * 还没有删除的站点
     */
    public function allSiteByPage($pagesize = 15)
    {
        $currentQuery = $this->orderBy('id', 'desc')->where('status','>', self::IS_DELETE_YES)->paginate($pagesize);
        return $currentQuery;
    }

    /**
     * 取得所有的站点
     *
     * @return array
     */
    public function allSite()
    {
        return $this->where('status','>', self::IS_DELETE_YES)->get()->toArray();
    }

    /**
     * 批量删除站点
     */
    public function deleteSite(array $ids)
    {
        return $this->whereIn('id', $ids)->update(array('status'=>self::IS_DELETE_YES));
    }

    public function filmNumsGroupBySiteId($siteIds){
        $siteIds = array_map('intval', $siteIds);
        $ids = implode(',', $siteIds);
        $prefix = \DB:: getTablePrefix();
        $sqlString = "SELECT COUNT(1) AS total, site_id FROM `{$prefix}film` WHERE site_id IN ({$ids}) GROUP BY site_id;";
        return \DB::select($sqlString);
    }
}
