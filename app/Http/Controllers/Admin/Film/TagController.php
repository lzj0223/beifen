<?php namespace App\Http\Controllers\Admin\Film;

use Request, Lang;
use App\Models\Admin\FilmTag as FilmTagModel;
use App\Models\Admin\FilmTagRelation as FilmTagRelationModel;
use App\Http\Controllers\Admin\Controller;

/**
 * 电影标签相关
 */
class TagController extends Controller
{
    /**
     * 显示标签列表
     */
    public function index()
    {
        $tagsModel = new FilmTagModel();
        $list = $tagsModel->getTagsList();

        $tagsIds = [];
        foreach ($list as $key => $value) {
            $tagsIds[] = $value['id'];
        }
        $filmNums = with(new FilmTagRelationModel())->filmNumsGroupByTagId($tagsIds);

        $filmNumsRes = [];
        foreach ($filmNums as $filmNum) {
            $filmNumsRes[$filmNum->tag_id] =  $filmNum->total;
        }

        foreach ($list as $key => $value) {
            $list[$key]['filmNums'] = isset($filmNumsRes[$value['id']]) ? $filmNumsRes[$value['id']] : 0 ;
        }

        $page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.film.tag.index', compact('list', 'page'));
    }

    /**
     * 删除电影标签
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $id = array_map('intval', $id);

        $FilmTagModel = new FilmTagModel();
        if($FilmTagModel->deleteTags($id) === false){
            return responseJson(Lang::get('common.action_error'));
        }
        with(new FilmTagRelationModel())->deleteTagByTagId($id);
        return responseJson(Lang::get('common.action_success'), true);
    }



}