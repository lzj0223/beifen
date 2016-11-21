<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

/**
 * 院线热门电影表模型
 *
 * @author jiang
 */
class FilmHot extends Model
{
    /**
     * 数据表名
     *
     * @var string
     */
    protected $table = 'film_hot';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'user_id', 'title','thumb', 'summary','director','screenwriter','country','show_time','long','main_performer','sort','status','c_time');

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
        return $this->select('film_hot.*','country.zh_name as country_name')
            ->leftJoin('country','film_hot.country','=','country.id')
            ->where('film_hot.id', $id)
            ->where('film_hot.status','>', self::IS_DELETE_YES)
            ->first();
    }
    /**
     * 取得指定信息
     *
     * @param string $tagName
     * @return array
     */
    public function getHots($pagesize=10)
    {
        return $this->select('film_hot.*','country.zh_name as country_name')
            ->leftJoin('country','film_hot.country','=','country.id')
            ->orderBy('film_hot.sort', 'desc')
            ->orderBy('film_hot.id', 'desc')
            ->where('film_hot.status','>', self::IS_DELETE_YES)
            ->paginate($pagesize);
    }


    /**
     * 新增热门电影
     */
    public function addHot($isertData)
    {
        return $this->create($isertData);;
    }
    //编辑热门电影
    public function updateHot($data,$id){
        return $this->where('id', $id)->update($data);
    }

    /**
     * 批量删除热门电影
     */
    public function deleteHots(array $ids)
    {
        return $this->whereIn('id', $ids)->update(array('status'=>self::IS_DELETE_YES));
    }
}
