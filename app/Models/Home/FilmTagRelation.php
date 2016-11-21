<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use App\Models\Home\FilmTag as FilmTagModel;
use App\Models\Home\Film as FilmModel;

/**
 * 电影标签关系表模型
 */
class FilmTagRelation extends Model
{
    /**
     * 电影标签数据表名
     *
     * @var string
     */
    protected $table = 'film_tag_relation';


    /**
     * 获取电影所属标签
     * @param $filmId
     * @return mixed
     */
    public function getTagsByFilmId($filmId)
    {
        $filmId = intval($filmId);
        return $this->join('film_tag', 'film_tag.id', '=', 'tag_id')
            ->select('film_tag.id as id', 'film_tag.tag')
            ->orderBy('film_tag.id', 'desc')
            ->where('film_tag.status', '>' ,FilmTagModel::IS_DELETE_YES)
            ->where('film_id',$filmId)
            ->get()->toArray();
    }

    /**
     * 获取某标签下的电影
     * @param $tagId
     * @param $pagesize
     * @return mixed
     */
    public function getFilmsByTagId($tagId,$pagesize=10){
        $tagId = intval($tagId);
        return $this->join('film', 'film.id', '=', 'film_id')
            ->select('film.id as id', 'film.summary', 'film.c_time','film.gather_url','film.title')
            ->where('film_tag_relation.tag_id',$tagId)
            ->where('film.status',FilmModel::IS_TATUS_YES)
            ->orderBy('film.id','desc')
            ->paginate($pagesize);
    }
}
