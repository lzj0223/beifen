<?php namespace App\Http\Controllers\Home;

use App\Models\Home\FilmTag as FilmTagModel;
use App\Models\Home\FilmTagRelation as FilmTagRelationModel;
use Request;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginator;

/**
 * btfilm 教程页
 */
class HelpController extends Controller
{
    /**
     * 教程页
     */
    public function index()
    {
        $seo_info = array(
            'title'=>'BTFILM教程_BTFILM搜索_BTFILM磁力搜索_BTFILM种子搜索_BTFILM影视搜索_BTFILM电影搜索',
            'keywords'=>'BTFILM,BTFILM搜索,BTFILM磁力搜索,BTFILM种子搜索,BTFILM影视搜索,BTFILM电影搜索',
            'desc'=>'BTFILM专业电影搜索引擎,海量电影等你来搜.'
        );
        $nav_id = 'Help-index';
        return view('home.help.index', compact('tags', 'page','seo_info','nav_id'));
    }
}