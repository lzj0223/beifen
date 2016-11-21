<?php namespace App\Services\Admin\FilmHot;

use Lang;
use App\Models\Admin\Film as FilmModel;
use App\Models\Admin\FilmHot as FilmHotModel;
use App\Services\Admin\FilmHot\Validate\FilmHot as FilmHotValidate;

use App\Services\Admin\SC;
use App\Services\Admin\BaseProcess;

/**
 * 文章处理
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
    private $FilmHotModel;


    /**
     * 表单验证对象
     *
     * @var object
     */
    private $FilmHotValidate;


    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->FilmModel) $this->FilmModel = new FilmModel();
        if( ! $this->FilmHotModel) $this->FilmHotModel = new FilmHotModel();
        if( ! $this->FilmHotValidate) $this->FilmHotValidate = new FilmHotValidate();
    }

    /**
     * 增加新的电影
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addHot(\App\Services\Admin\FilmHot\Param\FilmHotSave $data)
    {
        if( ! $this->FilmHotValidate->add($data))
        {
            $unValidateMsg = $this->FilmHotValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->time = date('Y-m-d H:i:s',time());
        $object->userId = SC::getLoginSession()->id;

        try
        {
            \DB::transaction(function() use ($data, $object)
            {
                $object->hotAutoId = $this->saveHot($data, $object);
                return true;
            });
        } catch (\Exception $e) {
            return $this->setErrorMsg(Lang::get('common.action_error').$e->getMessage());
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
    public function editHot(\App\Services\Admin\FilmHot\Param\FilmHotSave $data, $id)
    {
        if( ! $this->FilmHotValidate->edit($data))
        {
            $unValidateMsg = $this->FilmHotValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->hotAutoId = $id;
        try
        {
            $result = \DB::transaction(function() use ($data, $id, $object)
            {
                $this->updateHot($data, $object);
                return true;
            });
        }
        catch (\Exception $e)
        {
            $result = false;
            return $this->setErrorMsg(Lang::get('common.action_error').$e->getMessage());
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
        $data['status'] = FilmHotModel::IS_DELETE_YES;
        try
        {
            $result = \DB::transaction(function() use ($data, $ids)
            {
                if($this->FilmHotModel->deleteHots($ids) == false){
                    throw new \Exception("delete hot film  error.");
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
    private function updateHot(\App\Services\Admin\FilmHot\Param\FilmHotSave $data, $object)
    {
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = isset($data['status']) ? $data['status'] : 0;
        $dataContet['summary'] = $data['summary'];
        $dataContet['director'] = $data['director'];
        $dataContet['screenwriter'] = $data['screenwriter'];
        $dataContet['country'] = $data['country'];
        $dataContet['show_time'] = $data['show_time'];
        $dataContet['long'] = is_null($data['long']) ? 0 : $data['long'];
        $dataContet['sort'] = is_null($data['sort']) ? 0 : $data['sort'];
        if(isset($data['thumb']) && $data['thumb']){
            $dataContet['thumb'] = $data['thumb'];
        }
        $dataContet['main_performer'] = $data['main_performer'];


        $reuslt = $this->FilmHotModel->updateHot($dataContet, $object->hotAutoId);
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
    private function saveHot(\App\Services\Admin\FilmHot\Param\FilmHotSave $data, $object)
    {
        $dataContet['c_time'] = $object->time;
        $dataContet['user_id'] = $object->userId;
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = isset($data['status']) ? $data['status'] : 0;
        $dataContet['summary'] = $data['summary'];
        $dataContet['director'] = $data['director'];
        $dataContet['screenwriter'] = $data['screenwriter'];
        $dataContet['country'] = $data['country'];
        $dataContet['show_time'] = $data['show_time'];
        $dataContet['long'] = $data['long'];
        $dataContet['sort'] = $data['sort'];
        $dataContet['thumb'] = $data['thumb'];
        $dataContet['main_performer'] = $data['main_performer'];

        $insertObject = $this->FilmHotModel->addHot($dataContet);
        if( ! $insertObject->id)
        {
            throw new \Exception("save content error");
        }
        return $insertObject->id;
    }
}