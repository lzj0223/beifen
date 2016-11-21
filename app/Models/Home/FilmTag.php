<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

/**
 * 电影标签表模型
 */
class FilmTag extends Model
{
    /**
     * 电影标签数据表名
     *
     * @var string
     */
    protected $table = 'film_tag';
    
    /**
     * 电影标签的标识
     */
    CONST IS_DELETE_YES = -1;

    CONST IS_INDEX_YES = 1;

    /**
     * 取得首页标签
     *
     * @return array
     */
    public function getIndexTags()
    {
        return $this->orderBy('cliks', 'desc')->orderBy('id', 'desc')
            ->where('status', self::IS_INDEX_YES)->paginate(10);
    }


    public function getTagById($id){
        $id = intval($id);
        return $this->where('id',$id)->where('status','>',self::IS_DELETE_YES)->get()->first();
    }

    /**
     * 取得所有标签
     * @return mixed
     */
    public function getTagsByPage($pagesie=100){
        return $this->orderBy('order', 'desc')->orderBy('id', 'desc')
            ->where('status','>', self::IS_DELETE_YES)->paginate($pagesie);
    }

    /**
     * @param $id
     * @param int $pagesize
     * @return mixed
     */
    public function getFilmsByTagId($id,$pagesize = 10){
        $id = intval($id);
        return \DB::table('film_tag_relation')->join('film', 'film.id', '=', 'film_id')
            ->select('film.id as id', 'film.summary', 'film.c_time','film.gather_url','film.title')
            ->where('film_tag_relation.tag_id',$id)
            ->where('film.status','>',0)
            ->orderBy('film.id','desc')
            ->paginate($pagesize);
    }

}
