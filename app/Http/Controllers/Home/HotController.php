<?php namespace App\Http\Controllers\Home;

use App\Services\Home\Search\Process;
use App\Services\Douban;
use Request;

/**
 * 院线热门电影
 */
class HotController extends Controller
{
    /**
     * 电影首页
     */
    public function index()
    {
        $sort =  Request::input('sort');
        $tag = Request::input('tag');


        $sort = $sort ? $sort : 'recommend';
        $tag = $tag ? $tag : '热门';

        $douban = new  Douban();
        $_hots = $douban->get_list(0,$sort,$tag);

        $hots = $_hots['subjects'] ? $_hots['subjects'] : [];
        
        $rank = $douban->get_rank();
        $rank = is_array($rank) ? $rank : [];

        $cacheSecond = config('home.cache_control');
        $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
        $nav_id = 'Hot-index';

        $seo_info = array(
            'title'=>$tag.'电影_院线热门电影_BTFILM搜索',
            'keywords'=>'BTFILM,BTFILM搜索,热门电影搜索,热门电影',
            'desc'=>'BTFILM强大的电影资源搜索神器,BTFILM提供院线热门电影'.$tag.'搜索等服务'
        );


        return response(view('home.hot.index', compact('hots','rank','sort','tag','seo_info','nav_id')))
            ->header('Cache-Control', 'max-age='.$cacheSecond)
            ->header('Expires', $time);
    }
    
    public function mlist(){
        $start =  Request::input('start');
        $sort =  Request::input('sort');
        $tag = Request::input('tag');
        
        $start = $start ? $start : 0;
        
        $douban = new  Douban();
        $_hots = $douban->get_list($start,$sort,$tag);

        return json_encode(array('msg'=>'success','result'=>$_hots['subjects']));
    }

    /**
     * 电影内页
     */
    public function detail()
    {
        $id = Request::input('id');
        $douban = new  Douban();

        $info = $douban->get_detail($id);
        $photos = $douban->get_photos($id,'S');
        if (count($photos) > 10){
            $photos = array_slice($photos,0,10);
        }
        //$films = $this->search($info['title']);

        //compact('info','films')
        $cacheSecond = config('home.cache_control');
        $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
        $nav_id = 'Tag-index';

        $info['title'] = preg_replace('/\s{2,}/',' ',$info['title']);
        $seo_info = array(
            'title'=>$info['title'].'电影_院线热门电影_BTFILM搜索',
            'keywords'=>'BTFILM,BTFILM搜索,热门电影搜索,热门电影',
            'desc'=>'BTFILM强大的电影资源搜索神器,BTFILM提供院线热门电影'.$info['title'].'搜索等服务'
        );
        return response(view('home.hot.detail', compact('info','photos','id','seo_info','nav_id')))
            ->header('Cache-Control', 'max-age='.$cacheSecond)
            ->header('Expires', $time);
    }

}