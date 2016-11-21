<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 电影表模型
 *
 * @author jiang
 */
class Film extends Model
{
    /**
     * 电影删除的标识
     */
    CONST IS_DELETE_YES = -1;

    /**
     * 电影发布的标识
     */
    CONST IS_TATUS_YES = 1;

    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'film';

    /**
     * 表前缀
     * 
     * @var string
     */
    private $prefix;

    /**
     * 取得已发布电影列表信息
     * 
     * @return array
     */
    public function getFilmList($pagesize=10)
    {
        return $this->where('status', '=', self::IS_TATUS_YES)->orderBy('id','desc')->paginate($pagesize);;
    }

    /**
     * 取得电影详细信息
     * @param int $id
     * @return mixed
     */
    public function getFilmById($id){
        $id = intval($id);
        return $this->where('status', '=', self::IS_TATUS_YES)->where('id', '=', $id)->first();
    }

    /**
     * 取得电影详细信息
     * @param int $id
     * @return mixed
     */
    public function getFilmByIds(array $ids){
        return $this->whereIn('id',$ids)->where('status', '=', self::IS_TATUS_YES)->get();
    }

    /**
     * 获取电影资源
     * @param $filmId
     * @return mixed
     */
    public function getFilmSource($filmId){
        $filmId = intval($filmId);
        return \DB::table('film_source')->where('film_id',$filmId)->get();
    }
}
