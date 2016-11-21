<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 电影表模型
 *
 * @author jiang
 */
class Film extends Base
{
    /**
     * 电影数据表名
     *
     * @var string
     */
    protected $table = 'film';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id','user_id', 'title', 'content', 'summary' , 'gather_url','site_id','status','c_time');

    /**
     * 电影未删除的标识
     */
    CONST IS_DELETE_NO = 0;



    CONST IS_DELETE_YES = -1;


    /**
     * 取得未删除的信息
     *
     * @return array
     */
    public function AllFilms($search = [])
    {
        $currentQuery = $this->orderBy('id', 'desc')->where('status','>',self::IS_DELETE_YES);
        if(isset($search['site_id']) and ! empty($search['site_id'])) $currentQuery->where('site_id', $search['site_id']);
        if(isset($search['timeFrom'], $search['timeTo']) and (!empty($search['timeFrom'])) and (!empty($search['timeTo'])))
        {
            $currentQuery->whereBetween('c_time', [$search['timeFrom'], $search['timeTo']]);
        }
        if(isset($search['keyword']) && ! empty($search['keyword'])) {
            $currentQuery->where('title', 'like', "%{$search['keyword']}%");
        }

        $result = $currentQuery->paginate(self::PAGE_NUMS);
        return $result;
    }

    /**
     * 取得文章所属的标签
     *
     * @param int 文章的ID
     * @return  array 文章的标签
     */
    public function getFilmTags($filmId)
    {
        $filmId = (int) $filmId;
        $currentQuery = $this->from('film_tag_relation')->select(array('film_tag_relation.tag_id', 'film_tag.tag'))
            ->leftJoin('film_tag', 'film_tag_relation.tag_id', '=', 'film_tag.id')
            ->where('film_tag_relation.film_id', $filmId)->get();
        $tags = $currentQuery->toArray();
        return $tags;
    }


    /**
     * 增加新电影
     * 
     * @param array $data 所需要插入的信息
     */
    public function addFilm(array $data)
    {
        return $this->create($data);
    }

    /**
     * 修改电影
     * 
     * @param array $data 所需要插入的信息
     */
    public function editFilm(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    /**
     * 取得指定ID信息
     * 
     * @param intval $id 用户组的ID
     * @return array
     */
    public function getOneById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

    public function getFilmsByIds($ids){
        return $this->whereIn('id', $ids)->get();
    }

    /**
     * 批量删除电影
     */
    public function deleteFilm(array $data, array $ids)
    {
        return $this->whereIn('id', $ids)->update($data);
    }


}
