<?php namespace App\Http\Controllers\Admin\Film;

use Request,Lang,Session,Illuminate\Support\Facades\Input;
use App\Models\Admin\FilmHot as FilmHotModel;
use App\Models\Admin\Country as CountryModel;
use App\Services\Admin\FilmHot\Process as FilmHotActionProcess;
use App\Http\Controllers\Admin\Controller;
use App\Libraries\Js as Js;

/**
 * 电影标签相关
 */
class HotController extends Controller
{
    /**
     * 显示标签列表
     */
    public function index()
    {
        $FilmHotModel = new FilmHotModel();
        $list = $FilmHotModel->getHots();
        $page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.film.hot.index', compact('list', 'page','countrys'));
    }

    public function add(){
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'film.hot.add');
        $countrys = $this->getCountrys();
        return view('admin.film.hot.add', compact('formUrl','countrys'));
    }

    public function edit(){
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $info = (new FilmHotModel())->getOneById($id);
        if(empty($info)) return Js::error(Lang::get('content.not_found'));
        $info->country_name = $info->country ? $info->country .'-'. $info->country_name : '';
        $formUrl = R('common', 'film.hot.edit');
        $countrys = $this->getCountrys();
        return view('admin.film.hot.add', compact('info', 'formUrl', 'id','countrys'));
    }

    private function getCountrys(){
        $countrys = (new CountryModel())->getAll();
        $res = [];
        foreach($countrys as $value){
            $res[] = array($value['id'].'-'.$value['zh_name'],$value['name'],$value['code']);
        }
        return $res;
    }


    /**
     * 删除热门
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $id = array_map('intval', $id);

        $FilmHotActionProcess = new FilmHotActionProcess();
        if($FilmHotActionProcess->detele($id) === false){
            return responseJson(Lang::get('common.action_error'));
        }
        return responseJson(Lang::get('common.action_success'), true);
    }

    /**
     * 增加电影入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');

        $file = Input::file('thumb');
        if(!$file->isValid()){
            return responseJson('请选择要上传的图片！', false);
        }
        $file_res = upoadsImg($file);
        if($file_res['status']){
            $data['thumb'] = $file_res['path'];
        }
        if(isset($data['country'])&&$data['country']){
            $country = explode('-',$data['country']);
            $data['country'] = $country[0];
        }

        $param = new \App\Services\Admin\FilmHot\Param\FilmHotSave();
        $param->setAttributes($data);
        $manager = new FilmHotActionProcess();
        if($manager->addHot($param) !== false) return responseJson('保存成功', true);
        return responseJson($manager->getErrorMessage());
    }



    /**
     * 编辑入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = (array) Request::input('data');
        $id = intval(Request::input('id'));

        $file = Input::file('thumb');

        if(is_object($file)&&$file->isValid()){
            $file_res = upoadsImg($file);
            if(!$file_res['status']){
                return responseJson($file_res['msg'], false);
            }
            $data['thumb'] = $file_res['path'];
        }

        if(isset($data['country'])&&$data['country']){
            $country = explode('-',$data['country']);
            $data['country'] = $country[0];
        }

        $param = new \App\Services\Admin\FilmHot\Param\FilmHotSave();
        $param->setAttributes($data);
        $manager = new FilmHotActionProcess();
        if($manager->editHot($param, $id) !== false)
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'film.content.index');
            return responseJson('保存成功', true,$backUrl);
        }
        return responseJson($manager->getErrorMessage());
    }




}