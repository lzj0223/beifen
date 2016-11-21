<?php namespace App\Services\Admin\Film;

use Lang;
use App\Models\Admin\Film as FilmModel;
use App\Models\Admin\FilmTagRelation as FilmTagRelation;
use App\Models\Admin\FilmTag as FilmTagModel;
use App\Models\Admin\FilmSite as FilmSiteModel;
use App\Models\Admin\FilmSource as FilmSourceModel;
use App\Services\Admin\Film\Validate\Film as FilmValidate;

use App\Services\Admin\SC;
use App\Services\Admin\BaseProcess;

/**
 * 文章处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 电影模型
     *
     * @var object
     */
    private $FilmModel;

    /**
     * 电影资源表模型
     *
     * @var object
     */
    private $FilmSourceModel;

    /**
     * 电影标签关系表模型
     *
     * @var object
     */
    private $FilmTagsRelationModel;

    /**
     * 电影标签表模型
     *
     * @var object
     */
    private $FilmTagModel;

    /**
     * 文章表单验证对象
     *
     * @var object
     */
    private $FilmValidate;


    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->FilmModel) $this->FilmModel = new FilmModel();
        if( ! $this->FilmSourceModel) $this->FilmSourceModel = new FilmSourceModel();
        if( ! $this->FilmTagModel) $this->FilmTagModel = new FilmTagModel();
        if( ! $this->FilmTagsRelationModel) $this->FilmTagsRelationModel = new FilmTagRelation();
        if( ! $this->FilmValidate) $this->FilmValidate = new FilmValidate();
    }

    /**
     * 增加新的电影
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addFilm(\App\Services\Admin\Film\Param\FilmSave $data)
    {
        if( ! $this->FilmValidate->add($data))
        {
            $unValidateMsg = $this->FilmValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->time = date('Y-m-d H:i:s',time());
        $object->userId = SC::getLoginSession()->id;

        try
        {
            \DB::transaction(function() use ($data, $object)
            {
                $object->filmAutoId = $this->saveFilm($data, $object);
                if($data['tags']) {
                    $this->saveFilmTag($object, $data['tags']);
                }
                if($data['sources']){
                    $this->saveFilmSource($object, $data['sources']);
                }
                return true;
            });
        } catch (\Exception $e) {
            dd($e);
            return $this->setErrorMsg(Lang::get('common.action_error'));
        }
        return true;
    }

    /**
     * 编辑电影，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editFilm(\App\Services\Admin\Film\Param\FilmSave $data, $id)
    {
        if( ! $this->FilmValidate->edit($data))
        {
            $unValidateMsg = $this->FilmValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->filmAutoId = $id;

        try
        {
            $result = \DB::transaction(function() use ($data, $id, $object)
            {

                $this->updateFilm($data, $object);
                $this->saveFilmTag($object, $data['tags']);
                $this->saveFilmSource($object, $data['sources']);
                return true;
            });
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        if( ! $result)
        {
            return $this->setErrorMsg(Lang::get('common.action_error'));
        }
        return true;
    }

    /**
     * 删除电影，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param array $ids 要删除的文章的id
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        $data['status'] = FilmModel::IS_DELETE_YES;
        try
        {
            $result = \DB::transaction(function() use ($data, $ids)
            {
                $this->FilmModel->deleteFilm($data, $ids);
                if($this->FilmTagsRelationModel->deleteTagByFilmId($ids) === false){
                    throw new \Exception("delete film tag relation  error.");
                }
                if($this->FilmSourceModel->deleteSourcesByFilmId($ids) === false){
                    throw new \Exception("delete film source  error.");
                }
                return true;
            });
        } catch (\Exception $e) {
            $result = false;
        }

        if(!$result) return $this->setErrorMsg(Lang::get('common.action_error'));
        return $result;
    }

    /**
     * 保存到电影表，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param  array $data
     * @return int 自增的ID
     */
    private function updateFilm(\App\Services\Admin\Film\Param\FilmSave $data, $object)
    {
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = isset($data['status']) ? $data['status'] : FilmModel::IS_DELETE_NO;
        $dataContet['summary'] = $data['summary'];
        $dataContet['content'] = $data['content'];
        $dataContet['site_id'] = $data['site_id'];
        $dataContet['gather_url'] = $data['gather_url'];

        $reuslt = $this->FilmModel->editFilm($dataContet, $object->filmAutoId);
        if($reuslt === false)
        {
            throw new \Exception("save content error");
        }

        return $reuslt;
    }

    /**
     * 保存到电影表，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param  array $data
     * @return int 自增的ID
     */
    private function saveFilm(\App\Services\Admin\Film\Param\FilmSave $data, $object)
    {
        $dataContet['c_time'] = $object->time;
        $dataContet['user_id'] = $object->userId;
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = isset($data['status']) ? $data['status'] : FilmModel::IS_DELETE_NO;
        $dataContet['summary'] = $data['summary'];
        $dataContet['content'] = $data['content'];
        $dataContet['site_id'] = $data['site_id'];
        $dataContet['gather_url'] = $data['gather_url'];

        $insertObject = $this->FilmModel->addFilm($dataContet);
        if( ! $insertObject->id)
        {
            throw new \Exception("save content error");
        }
        return $insertObject->id;
    }

    /**
     * 保存电影资源，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param object $object 文章的信息
     * @param array $classify 分类
     */
    private function saveFilmSource($object, $sources)
    {
        if($this->FilmSourceModel->deleteSourcesByFilmId(array($object->filmAutoId)) === false){
            throw new \Exception("delete film's source error.");
        }
        $insertData = [];
        foreach($sources as $key => $source)
        {
            if(!$source){continue;}
            $insertData[] = array(
                'film_id' => intval($object->filmAutoId),
                'link' => $source,
            );
        }

        if(count($insertData) > 0){
            $result = $this->FilmSourceModel->addSources($insertData);
            if(!$result) throw new \Exception("add film's source error.");
        }

    }

    /**
     * 保存电影的标签，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param int $object->contentAutoId 文章的ID
     * @param array $tags 标签
     */
    private function saveFilmTag($object, $tags)
    {
        if($this->FilmTagsRelationModel->deleteTagByFilmId($object->filmAutoId) === false){
            throw new \Exception("delect tags film relation error.");
        }
        $insertData = [];
        foreach($tags as $tagName)
        {
            $tagInfo = $this->FilmTagModel->addTagsIfNotExistsByName($tagName);
            if(!$tagInfo->id) throw new \Exception("add film tags if not exists by name error.");
            $insertData[] = [
                'film_id' => $object->filmAutoId,
                'tag_id' => $tagInfo->id,
            ];
        }

        $result = $this->FilmTagsRelationModel->addTagFilmRelations($insertData);
        if( ! $result) throw new \Exception("add tags film relation error.");

        return $result;
    }
}