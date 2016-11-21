<?php namespace App\Http\Controllers\Admin\Film;

use Request, Lang, Session;
use App\Models\Admin\FilmSite as FilmSiteModel;
use App\Services\Admin\FilmSite\Process as FilmSiteActionProcess;
use App\Http\Controllers\Admin\Controller;

/**
 * 电影采集站点
 *
 * @author jiang <mylampblog@163.com>
 */
class SiteController extends Controller
{
    /**
     * 显示分类列表
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
        $manager = new FilmSiteActionProcess();
    	$list = $manager->unDeleteSite();
    	$page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.film.site.index', compact('list', 'page'));
    }

    /**
     * 增加文章分类
     */
    public function add()
    {
    	if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'film.site.add');
        return view('admin.film.site.edit', compact('formUrl'));
    }

    /**
     * 增加文章分类入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        foreach($data as $key=>$value){
            if(is_null($value))$data[$key] = '';
        }
        $param = new \App\Services\Admin\FilmSite\Param\FilmSiteSave();
        $param->setAttributes($data);
        $manager = new FilmSiteActionProcess();
        if($manager->addSite($param) !== false) return responseJson('保存成功！', true,R('common', 'film.site.index'));
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 编辑文章分类
     */
    public function edit()
    {
    	if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return responseJson(Lang::get('common.illegal_operation'));

        $info = (new FilmSiteModel())->getOneById($id);
        if(empty($info)) return responseJson(Lang::get('filmsite.not_found'));
        $formUrl = R('common', 'film.site.edit');
        return view('admin.film.site.edit', compact('info', 'formUrl', 'id'));
    }

    /**
     * 编辑文章分类入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return responseJson(Lang::get('common.illegal_operation'));
        $param = new \App\Services\Admin\FilmSite\Param\FilmSiteSave();
        $param->setAttributes($data);
        $manager = new FilmSiteActionProcess();
        if($manager->editSite($param))
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'film.site.index');
            return responseJson('保存成功！', true,$backUrl);
        }
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 删除文章分类
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new FilmSiteActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

}