<?php namespace App\Http\Controllers\Admin\Film;

use Request, Lang, Session;
use App\Models\Admin\Film as FilmModel;
use App\Models\Admin\FilmSource as FilmSourceModel;
use App\Services\Admin\Film\Process as FilmActionProcess;
use App\Models\Admin\FilmSite as FilmSiteModel;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 电影内容管理
 */
class ContentController extends Controller
{
    /**
     * 显示首页
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);

        $search['keyword'] = strip_tags(Request::input('keyword'));
        $search['site_id'] = strip_tags(Request::input('site_id'));
        $search['timeFrom'] = strip_tags(Request::input('time_from'));
        $search['timeTo'] = strip_tags(Request::input('time_to'));

        $list = (new FilmModel())->AllFilms($search);
        $page = $list->setPath('')->appends(Request::all())->render();

        $filmSite = (new FilmSiteModel())->allSite();
        return view('admin.film.content.index',
            compact('list', 'page', 'search','filmSite')
        );
    }

    /**
     * 添加新电影
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'film.content.add');
        $filmSite = (new FilmSiteModel())->allSite();
        return view('admin.film.content.add', compact('formUrl','filmSite'));
    }

    /**
     * 删除电影
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new FilmActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

    /**
     * 编辑电影
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $info = (new FilmModel())->getOneById($id);
        if(empty($info)) return Js::error(Lang::get('content.not_found'));
        $filmSite = (new FilmSiteModel())->allSite();
        $info = $this->joinFilmTags($info);
        $info = $this->joinFilmSources($info);
        $formUrl = R('common', 'film.content.edit');
        return view('admin.film.content.add', compact('info', 'formUrl', 'id','filmSite'));
    }
    
    /**
     * 增加电影入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        if($data['tags']){
            $data['tags'] = explode(';', $data['tags']);
        }else{
            unset($data['tags']);
        }

        $param = new \App\Services\Admin\Film\Param\FilmSave();
        $param->setAttributes($data);
        $manager = new FilmActionProcess();
        if($manager->addFilm($param) !== false) return responseJson('保存成功', true);
        return responseJson($manager->getErrorMessage());
    }


    /**
     * 取回当前电影的资源
     * 
     * @param  array $filmInfo 当前电影的信息
     * @return array              整合后的当前电影信息
     */
    private function joinFilmSources($filmInfo)
    {
        $filmInfo['sources']  = (new FilmSourceModel())->getListByFilmId($filmInfo['id']);
        return $filmInfo;
    }

    /**
     * 取回当前电影的所属标签
     * 
     * @param  array $filmInfo 当前电影的信息
     * @return array              整合后的当前文章信息
     */
    private function joinFilmTags($filmInfo)
    {
        $tagsInfo = (new FilmModel())->getFilmTags($filmInfo['id']);
        $tagsIds = [];
        foreach ($tagsInfo as $key => $value)
        {
            $tagsIds[] = $value['tag'];
        }
        $filmInfo['tagsInfo'] = $tagsIds;
        return $filmInfo;
    }
    
    /**
     * 编辑文章入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = (array) Request::input('data');
        $id = intval(Request::input('id'));
        $data['tags'] = explode(';', $data['tags']);
        $param = new \App\Services\Admin\Film\Param\FilmSave();
        $param->setAttributes($data);
        $manager = new FilmActionProcess();
        if($manager->editFilm($param, $id) !== false)
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'film.content.index');
            return responseJson('保存成功', true,$backUrl);
        }
        return responseJson($manager->getErrorMessage());
    }
}