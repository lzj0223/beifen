<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Film as FilmModel;
use App\Models\Home\FilmTag as FilmTagModel;
use App\Models\Home\FilmTagRelation as FilmTagRelationModel;
use Request;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginator;

class IndexController extends Controller
{
    /**
     * 电影首页
     */
    public function index()
    {
        $tags = (new FilmTagModel())->getIndexTags();
        $cacheSecond = config('home.cache_control');
        $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
        $seo_info = array(
            'title'=>'BTFILM_BTFILM磁力搜索_BTFILM种子搜索_BTFILM影视搜索_BTFILM电影搜索_最新电影_BTFILM搜索',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索,BTFILM最新电影',
            'desc'=>'BTFILM一个强大电影资源搜索神器,BTFILM提供bt搜索、磁力下载、种子资源搜索、影视资源搜索、电影资源搜索、最新电影资源下载等服务'
        );
        $nav_id = 'Index-index';
        return response(view('home.index.index', compact('tags','seo_info','nav_id')))
            ->header('Cache-Control', 'max-age='.$cacheSecond)
            ->header('Expires', $time);
    }

    /**
     * 最新收录
     */
    public function gather(){
        $pagesize = 10;

        $offset = Request::input('page');
        if($offset > 100){
            return abort(404);
        }
        $FilmModel = new FilmModel();
        $films = $FilmModel->getFilmList($pagesize);

        $total = $films->total();
        $total = $total > ($pagesize*100) ?  ($pagesize*100) : $total;

        $page = '';
        if( ! empty($films)){
            //分页信息
            $page = (new LengthAwarePaginator($films,$total,$pagesize))->setPath('')->appends(Request::all())->render();

            //取每部电影的标签
            $FilmTagRelationModel = new FilmTagRelationModel();
            foreach($films as $key => $film){
                $films[$key]['tags'] = $FilmTagRelationModel->getTagsByFilmId($film->id);
            }
        }

        $seo_info = array(
            'title'=>'BTFILM最新电影_BTFILM磁力搜索_BTFILM种子搜索_BTFILM影视搜索_BTFILM电影搜索_最新电影_BTFILM搜索',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索,BTFILM最新电影',
            'desc'=>'BTFILM最新电影提供搜索相关电影,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索的服务'
        );
        $nav_id = 'Index-gather';
        return view('home.index.gather', compact('films', 'page','total','seo_info','nav_id'));
    }

    /**
     * 电影内页
     */
    public function detail()
    {
        $id = Request::input('id');
        if(!$id){
            $id = func_get_arg(0);
        }

        $FilmModel = new FilmModel();

        $info = $FilmModel->getFilmById($id);

        $sources = $FilmModel->getFilmSource($id);
        $kankan = [];

        foreach($sources as $value){
            if(preg_match('/^https?:\/\/.*/',$value->link)){
                continue;
            }
            $kankan[] = $value->link;
        }

        $tags = (new FilmTagRelationModel())->getTagsByFilmId($id);

        $seo_info = array(
            'title'=>$info['title'].'_BTFILM专业电影搜索引擎_海量电影等你来搜!',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索,BTFILM最新电影',
            'desc'=>'BTFILM专业电影搜索引擎，海量电影等你来搜,'.$info['summary']
        );
        $nav_id = 'Index-detail';
        return view('home.index.detail', compact('info','sources','tags','kankan','seo_info','nav_id'));
    }

}