<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 电影标签表模型
 *
 * @author jiang
 */
class FilmTag extends Base
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'film_tag';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'tag', 'sort', 'status');

    /**
     * 文章标签库的is_delete状态
     */
    CONST TAGS_LIB_IS_DELETE_NO = 0;

    /**
     * 文章标签库的is_delete状态
     */
    CONST TAGS_LIB_IS_DELETE_YES = -1;

    /**
     * 取得指定信息
     * 
     * @param string $tagName
     * @return array
     */
    public function getOneByName($tagName)
    {
        return $this->where('tag', $tagName)->first();
    }

    /**
     * 插入新的标签
     */
    public function addTagsIfNotExistsByName($tagName)
    {
        if($info = $this->where('tag', $tagName)->first()) return $info;
        $isertData = ['tag' => $tagName ,'status' => self::TAGS_LIB_IS_DELETE_NO];
        $info = $this->create($isertData);
        return $info;
    }

    /**
     * 还没有删除的标签
     */
    public function getTagsList($pagesize = 15)
    {
        $currentQuery = $this->orderBy('id', 'desc')->where('status','>', self::TAGS_LIB_IS_DELETE_YES)->paginate($pagesize);
        return $currentQuery;
    }

    /**
     * 批量删除标签
     */
    public function deleteTags(array $ids)
    {
        return $this->whereIn('id', $ids)->update(array('status'=>self::TAGS_LIB_IS_DELETE_YES));
    }
}
