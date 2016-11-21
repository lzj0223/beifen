<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 电影资源表模型
 *
 * @author jiang
 */
class FilmSource extends Base
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'film_source';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id','film_id', 'link');


    /**
     * 取得指定信息
     * 
     * @param string $tagName
     * @return array
     */
    public function getListByIds(array $ids)
    {
        return $this->whereIn('id', $ids)->orderBy('id', 'desc')->get();
    }

    /**
     * 取得指定信息
     *
     * @param string $tagName
     * @return array
     */
    public function getListByFilmId($filmId)
    {
        $filmId = intval($filmId);
        return $this->where('film_id', $filmId)->orderBy('id', 'desc')->get()->toArray();
    }

    /**
     * 批量增加新资源链接
     */
    public function addSources(array $datas)
    {
        return $this->insert($datas);
    }



    /**
     * 批量删除资源链接
     */
    public function deleteSources($ids)
    {
        if(is_array($ids)){
            return $this->whereIn('id', $ids)->delete();
        }else{
            return $this->whereIn('id', $ids)->delete();
        }
    }

    /**
     * 根据电影ID删除资源
     * @param $filmId
     * @return mixed
     */
    public function deleteSourcesByFilmId($filmId){
        if(is_array($filmId)){
            return $this->whereIn('film_id', $filmId)->delete();
        }else{
            return $this->where('film_id', $filmId)->delete();
        }
    }
}
