<?php namespace App\Http\Controllers\Mobile;

use App\Models\Home\Film as FilmModel;
use App\Models\Home\FilmTag as FilmTagModel;
use App\Models\Home\FilmTagRelation as FilmTagRelationModel;
use App\Models\Admin\FilmSite as FilmSiteModel;
use Illuminate\Contracts\Encryption\EncryptException;
use Mockery\Exception;
use Request;

class IndexController extends Controller
{
    /**
     * 最新收录
     */
    public function index(){
        $pagesize = 10;

        $offset = Request::input('page');
        if($offset > 100){
            return abort(404);
        }

        $FilmSiteModel = new FilmSiteModel();
        $filmSite_temp = $FilmSiteModel->allSite();
        $film_sites = [];
        foreach($filmSite_temp as $value){
            $film_sites[$value['id']] = $value;
        }

        $keyword = Request::input('search');
        if($keyword){
            $res_films = $this->_search($keyword);
            $films = $res_films['films'];
            $total = $res_films['total'];
            foreach($films as $key=>$value){
                $films[$key]['title'] = $value['highlightTitle'];
                $films[$key]['summary'] =$value['content'];
                $films[$key]['c_time'] = substr($value['c_time'],0,strpos($value['c_time'],' '));
                $films[$key]['site'] = $film_sites[$value['site_id']]['site_name'];
            }
        }else{
            $FilmModel = new FilmModel();
            $films = $FilmModel->getFilmList($pagesize);
            $total = $films->total();
            $total = $total > ($pagesize*100) ?  ($pagesize*100) : $total;
            foreach($films as $key=>$value){
                $films[$key]['title'] = mb_substr($value['title'],0,16);
                $films[$key]['summary'] = mb_substr(strip_tags($value['summary']),0,38);
                $films[$key]['c_time'] = substr($value['c_time'],0,strpos($value['c_time'],' '));
                $films[$key]['site'] = $film_sites[$value['site_id']]['site_name'];
            }
        }




        return view('mobile.index.index', compact('films', 'page','total','seo_info','keyword'));
    }



    public function get_list(){
        $offset = Request::input('page');
        $limit =  Request::input('limit');

        if($offset > 100){
            return abort(404);
        }
        $limit = $limit ? $limit : 20;

        $FilmSiteModel = new FilmSiteModel();
        $filmSite_temp = $FilmSiteModel->allSite();
        $film_sites = [];
        foreach($filmSite_temp as $value){
            $film_sites[$value['id']] = $value;
        }

        $keyword = Request::input('search');
        if($keyword){
            $res_films = $this->_search($keyword);
            $films = $res_films['films'];
            $total = $res_films['total'];
            foreach($films as $key=>$value){
                $films[$key]['title'] = $value['highlightTitle'];
                $films[$key]['summary'] =$value['content'];
                $films[$key]['c_time'] = substr($value['c_time'],0,strpos($value['c_time'],' '));
                $films[$key]['site'] = $film_sites[$value['site_id']]['site_name'];
            }
        }else{
            $FilmModel = new FilmModel();
            $films = $FilmModel->getFilmList($limit);
            $total = $films->total();
            $total = $total > ($limit*100) ?  ($limit*100) : $total;
            $films = $films->items();
            foreach($films as $key=>$value){
                $films[$key]['title'] = $value['title'];
                $films[$key]['summary'] =$value['summary'];
                $films[$key]['c_time'] = substr($value['c_time'],0,strpos($value['c_time'],' '));
                $films[$key]['site'] = $film_sites[$value['site_id']]['site_name'];
            }
        }

        echo json_encode(['msg'=>'success','data'=>['total'=>$total,'items'=> $films]]);
        exit();
    }

    private function _search($keyword)
    {
        $pagesize = 10;
        $offset = Request::input('page');
        $offset = $offset > 100 ? 100 : $offset;
        $sort = Request::input('sort');

        $searchProcess = new \App\Services\Home\Search\Process();
        $res = $searchProcess->search($keyword,$offset,$pagesize,$sort);


        $films = $res['films'] ? $res['films'] : array();
        $total = $res['total'] > 100*$pagesize ? 100*$pagesize : $res['total'];

        return array('films'=>$films,'total'=>$total);
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
        return view('mobile.index.detail', compact('info','sources','tags','kankan','seo_info','nav_id'));
    }

}