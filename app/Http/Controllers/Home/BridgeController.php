<?php namespace App\Http\Controllers\Home;

use Request;
/**
 * 外站链接中转
 */
class BridgeController extends Controller
{
    public function index(){
        $url = Request::input('url');
        $msg = Request::input('msg');

        $url = urldecode($url);
        $msg = $msg ? $msg : '正在跳转...';
        $seo_info = array(
            'title'=>'BTFILM专业电影搜索引擎，海量电影等你来搜——BTFILM',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索,BTFILM最新电影',
            'desc'=>'BTFILM一个强大电影资源搜索神器,BTFILM提供bt搜索、磁力下载、种子资源搜索、影视资源搜索、电影资源搜索、最新电影资源下载等服务'
        );
        return response(view('home.bridge.index', compact('url','msg','seo_info')));
    }

    public function douban(){
        $url = Request::input('url');
        $id = Request::input('id');

        $snoopy = new \App\Libraries\Snoopy();
        $snoopy->referer = 'https://movie.douban.com/subject/'.$id;
        $snoopy->fetch($url);
        header('Content-type: image/jpg');
        echo $snoopy->results;
    }
}