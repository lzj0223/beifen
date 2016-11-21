<?php namespace App\Http\Controllers\Home;
use App\Services\Home\Search\Process;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginator;
use Request;

/**
 * btfilm搜索页
 *
 * @author jiang <mylampblog@163.com>
 */
class SearchController extends Controller
{
    /**
     * btfilm搜索页
     */
    public function index()
    {
        $pagesize = 10;
        $keyword = Request::input('search');
        if(!$keyword){
            $keyword = func_get_arg(0);
        }

        $offset = Request::input('page');
        $offset = $offset > 100 ? 100 : $offset;
        $sort = Request::input('sort');


        $time_search = getMillisecond();

        $searchProcess = new Process();
        $res = $searchProcess->search($keyword,$offset,$pagesize,$sort);

        $films = $res['films'] ? $res['films'] : array();
        $total = $res['total'] > 100*$pagesize ? 100*$pagesize : $res['total'];
        $words = $res['words'] ? $res['words'] : array();

        $page = (new LengthAwarePaginator($films,$total,$pagesize))->setPath('')->appends(Request::all())->render();

        $time_search = (getMillisecond() - $time_search)/1000;

        $seo_info = array(
            'title'=>$keyword.'相关电影_BTFILM搜索_BTFILM磁力搜索_BTFILM种子搜索_BTFILM影视搜索_BTFILM电影搜索',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索',
            'desc'=>'BTFILM搜索提供搜索'.$keyword.'相关电影,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索的服务.BTFILM专业电影搜索引擎,海量电影等你来搜.'
        );
        $nav_id = 'Search-index';
        return view('home.search.index', compact('films', 'page','total','words','keyword','time_search','sort','seo_info','nav_id'));
    }

}