<?php namespace App\Http\Controllers\Home;

use App\Models\Home\FilmTag as FilmTagModel;
use App\Models\Home\FilmTagRelation as FilmTagRelationModel;
use Request;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginator;

/**
 * btfilm 标签相关
 */
class TagController extends Controller
{
    /**
     * 标签库首页
     */
    public function index()
    {
        $pagesize = 200;
        $offset = Request::input('page');
        if($offset>100){
            return abort(404);
        }
        $tags = (new FilmTagModel())->getTagsByPage($pagesize);
        $total = $tags->total();
        $total = $total*$pagesize > 20000 ? 20000 :$total*$pagesize;

        $page = '';
        if( ! empty($tags)) $page = (new LengthAwarePaginator($tags,$total,$pagesize))->setPath('')->appends(Request::all())->render();
        $seo_info = array(
            'title'=>'BTFILM标签库_BTFILM搜索_BTFILM磁力搜索_BTFILM种子搜索_BTFILM影视搜索_BTFILM电影搜索',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索',
            'desc'=>'BTFILM专业电影搜索引擎,海量电影等你来搜.'
        );
        $nav_id = 'Tag-index';
        return view('home.tag.index', compact('tags', 'page','seo_info','nav_id'));
    }

    /**
     * 该标签下的所有电影
     */
    public function detail(){
        $id = Request::input('id');
        if(!$id){
            redirect('/tag.html');
        }
        $time_search = getMillisecond();

        $tag = (new FilmTagModel())->getTagById($id);
        if(!$tag){
            return abort(404);
        }

        $FilmTagRelationModel = new FilmTagRelationModel();

        $offset = Request::input('page');
        if($offset > 100){
            return abort(404);
        }

        $pagesize = 15;
        //根据标签id获取电影
        $films = $FilmTagRelationModel->getFilmsByTagId($id,$pagesize);
        $total = $films->total();
        $total = $total > 100*$pagesize ? 100*$pagesize : $total;

        $page = '';
        if( ! empty($films)){
            //分页信息
            $page = (new LengthAwarePaginator($films,$total,$pagesize))->setPath('')->appends(Request::all())->render();

            //取每部电影的标签
            foreach($films as $key => $film){
                $films[$key]['tags'] = $FilmTagRelationModel->getTagsByFilmId($film->id);
            }
        }

        $time_search = (getMillisecond() - $time_search)/1000;

        $seo_info = array(
            'title'=>$tag['tag'].'标签相关电影_BTFILM专业电影搜索引擎_海量电影等你来搜',
            'keywords'=>$tag['tag'].'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索',
            'desc'=>'BTFILM提供'.$tag['tag'].'标签相关电影搜索服务,BTFILM专业电影搜索引擎,海量电影等你来搜.'
        );
        $nav_id = 'Tag-detail';
        return view('home.tag.detail', compact('films', 'page','total','tag','time_search','seo_info','nav_id'));
    }
}