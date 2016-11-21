<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 院线热门电影表模型
 *
 * @author jiang
 */
class Country extends Base
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'name', 'zh_name','code', 'code2','is_show');

    /**
     * 删除状态
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
     * 取得指定信息
     *
     * @param string $tagName
     * @return array
     */
    public function getAll()
    {
        return self::all();
    }

}
