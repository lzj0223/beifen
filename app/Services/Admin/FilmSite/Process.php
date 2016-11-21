<?php namespace App\Services\Admin\FilmSite;

use Lang;
use App\Models\Admin\FilmSite as FilmSiteModel;
use App\Services\Admin\FilmSite\Validate\FilmSite as FilmSiteValidate;

use App\Services\Admin\SC;
use App\Services\Admin\BaseProcess;

/**
 * 站点处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 站点模型
     *
     * @var object
     */
    private $FilmSiteModel;

    /**
     * 表单验证对象
     *
     * @var object
     */
    private $FilmSiteValidate;


    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->FilmSiteModel) $this->FilmSiteModel = new FilmSiteModel();
        if( ! $this->FilmSiteValidate) $this->FilmSiteValidate = new FilmSiteValidate();
    }

    /**
     * 增加新的站点
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addSite(\App\Services\Admin\FilmSite\Param\FilmSiteSave $data)
    {
        if( ! $this->FilmSiteValidate->add($data))
        {
            $unValidateMsg = $this->FilmSiteValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }
        if( ! isset($data['id'])){
            unset($data['id']);
        }

        $object = new \stdClass();
        $object->userId = SC::getLoginSession()->id;

        try
        {
            \DB::transaction(function() use ($data, $object)
            {
                $this->saveSite($data, $object);
                return true;
            });
        } catch (\Exception $e) {
            dd($e);
            return $this->setErrorMsg(Lang::get('common.action_error'));
        }
        return true;
    }

    /**
     * 编辑站点，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editSite(\App\Services\Admin\FilmSite\Param\FilmSiteSave $data)
    {
        if( ! isset($data['id'])) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = intval($data['id']); unset($data['id']);

        if( ! $this->FilmSiteValidate->edit($data))
        {
            $unValidateMsg = $this->FilmSiteValidate->getErrorMessage();
            return $this->setErrorMsg($unValidateMsg);
        }

        $object = new \stdClass();
        $object->filmAutoId = $id;
        $object->userId = SC::getLoginSession()->id;

        try {
            $result = \DB::transaction(function() use ($data, $id, $object)
            {
                $this->updateSite($data, $object);
                return true;
            });
        } catch (\Exception $e) {
            $result = false;
        }

        if( ! $result)
        {
            $this->setErrorMsg(Lang::get('common.action_error'));
            return false;
        }
        return true;
    }

    /**
     * 删除站点，因为使用了事务，如果没有成功请手动抛出异常
     * 
     * @param array $ids 要删除的文章的id
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        try
        {
            $result = \DB::transaction(function() use ($ids)
            {
                $this->FilmSiteModel->deleteSite($ids);
                return true;
            });
        } catch (\Exception $e) {
            $result = false;
        }

        if(!$result) return $this->setErrorMsg(Lang::get('common.action_error'));
        return $result;
    }

    /**
     * 取得站点列表信息
     */
    public function unDeleteSite()
    {
        $site = $this->FilmSiteModel->allSiteByPage();
        $siteIds = [];
        foreach ($site as $key => $value) {
            $siteIds[] = $value['id'];
        }

        $filmNumsAll = $this->FilmSiteModel->filmNumsGroupBySiteId($siteIds);
        $filmNums = [];
        foreach ($filmNumsAll as $filmNum) {
            $filmNums[$filmNum->site_id] = $filmNum->total;
        }

        foreach ($site as $key => $value) {
            $site[$key]['filmNum'] = isset($filmNums[$value['id']]) ? $filmNums[$value['id']] : 0;
        }
        return $site;
    }

    /**
     * 保存到站点表，因为使用了事务，如果没有成功请手动抛出异常
     *
     * @param  array $data
     * @return int 自增的ID
     */
    private function updateSite(\App\Services\Admin\FilmSite\Param\FilmSiteSave $data, $object)
    {
        $dataContet['user_id'] = $object->userId;
        $dataContet['site_name'] = $data['site_name'];
        $dataContet['status'] = isset($data['status']) ? $data['status'] : FilmSiteModel::IS_DELETE_NO;
        $dataContet['site_url'] = $data['site_url'];
        $dataContet['list_url'] = $data['list_url'];
        $dataContet['list_reg'] = $data['list_reg'];
        $dataContet['content_reg'] = $data['content_reg'];
        $dataContet['page_reg'] = $data['page_reg'];
        //$dataContet['charset'] = $data['charset'];

        $reuslt = $this->FilmSiteModel->updateSite($dataContet, $object->filmAutoId);
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
    private function saveSite(\App\Services\Admin\FilmSite\Param\FilmSiteSave $data, $object)
    {
        $dataContet['c_time'] = date('Y-m-d H:i:s',time());
        $dataContet['user_id'] = $object->userId;
        $dataContet['site_name'] = $data['site_name'];
        $dataContet['status'] = isset($data['status']) ? $data['status'] : FilmSiteModel::IS_DELETE_NO;
        $dataContet['site_url'] = $data['site_url'];
        $dataContet['list_url'] = $data['list_url'];
        $dataContet['list_reg'] = $data['list_reg'];
        $dataContet['content_reg'] = $data['content_reg'];
        $dataContet['page_reg'] = $data['page_reg'];
        //$dataContet['charset'] = $data['charset'];

        $insertObject = $this->FilmSiteModel->addSite($dataContet);
        if( ! $insertObject->id)
        {
            throw new \Exception("save content error");
        }
        return $insertObject->id;
    }
}