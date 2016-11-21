<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 电影标签关系表模型
 *
 * @author jiang
 */
class FilmTagRelation extends Base
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'film_tag_relation';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'film_id', 'tag_id');

    /**
     * 批量删除
     */
    public function deleteTagsRelation(array $ids)
    {
        return $this->whereIn('film_id', $ids)->delete();
    }

    /**
     * 根据电影ID删除标签
     * @param $filmId
     * @return mixed
     */
    public function deleteTagByFilmId($filmId){
        if(is_array($filmId)){
            return $this->whereIn('film_id', $filmId)->delete();
        }else{
            return $this->where('film_id', $filmId)->delete();
        }
    }

    /**
     * 根据标签ID删除标签
     * @param $filmId
     * @return mixed
     */
    public function deleteTagByTagId($tagId){
        if(is_array($tagId)){
            return $this->whereIn('tag_id', $tagId)->delete();
        }else{
            return $this->where('tag_id', $tagId)->delete();
        }
    }

    /**
     * 增加数据
     */
    public function addTagFilmRelation($filmId, $tagId)
    {
        $isertData = ['film_id' => $filmId, 'tag_id' => $tagId];
        return $this->create($isertData);
    }

    /**
     * 批量增加数据
     */
    public function addTagFilmRelations(array $datas)
    {
        return $this->insert($datas);
    }

    /**
     * 取得所有指定标签的电影数
     */
    public function filmNumsGroupByTagId(array $tagIds)
    {
        $tagIds = array_map('intval', $tagIds);
        //$res = $this->whereIn('tag_id', $tagIds)->groupBy('tag_id')->count();
        $tags = implode(',', $tagIds);
        $prefix = \DB:: getTablePrefix();
        $sqlString = "SELECT COUNT(1) AS total, tag_id FROM `{$prefix}film_tag_relation` WHERE tag_id IN ($tags) GROUP BY tag_id;";
        return \DB::select($sqlString);

    }

}
