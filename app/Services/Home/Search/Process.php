<?php namespace App\Services\Home\Search;

use Lang;
use App\Services\Home\Search\SphinxClient as SphinxClient;
use App\Models\Home\Film as FilmModel;
use App\Models\Home\FilmTagRelation as FilmTagRelationModel;
use App\Libraries\Spliter;
use App\Services\Home\BaseProcess;

/**
 * 搜索处理
 */
class Process extends BaseProcess
{
    /**
     * sphinx client object
     *
     * @var string
     */
    private $sphinx;

    /**
     * sphinx server
     *
     * @var string
     */
    private $sphinxServer = '127.0.0.1';

    /**
     * sphinx port
     *
     * @var string
     */
    private $sphinxPort = 9312;

    private $sphinxIndex = 'main';

    public $sphinxSortModel = array(
        //1=>array(0 ,'',1,'综合排序',''),//按相关度降序排列（最好的匹配排在最前面）
        2=>array(4 ,'@weight desc,@id desc',3,'相关度'),
        3=>array(4 ,'@weight asc,@id desc',2,'相关度'),
        4=>array(4 ,'@id desc,@weight desc',5,'更新时间'),
        5=>array(4 ,'@id asc,@weight desc',4,'更新时间'),
    );


    /**
     * 初始化sphinx客户端
     */
    public function search($keyword,$page,$pagesize,$sort = 3)
    {
        $page = $page ? $page : 1;
        $limits['offset'] = ($page-1)*$pagesize;
        $limits['num'] = $pagesize;

        if(!isset($this->sphinxSortModel[$sort])){
            $sort = 2;
        }

        $this->sphinx = $this->initSphinxClient($limits,$this->sphinxSortModel[$sort]);


        //$this->sphinx->setFieldWeights(array('tilte'=>2000,'content'=>500));
        $res = $this->sphinx->Query ($keyword, $this->sphinxIndex);
        //dd($this->sphinx->_error);
        $filmIds = $this->prepareSphinxResult($res);
        if(!$filmIds){
            return false;
        }
        $films = (new FilmModel())->getFilmByIds($filmIds);
        //排序
        $films = $this->filmsSort($films,$filmIds);
        //取电影标签
        $FilmTagRelationModel = new FilmTagRelationModel();
        $content = [];
        foreach($films as $key=>$film){
            $content[] = $film->content;
            $films[$key]['tags'] = $FilmTagRelationModel->getTagsByFilmId($film->id);
        }

        $opts = array(
            "before_match"          => "<span class=\"highlight\">",
            "after_match"           => "</span>",
            "chunk_separator"       => "...",
            "limit"                 => 300,
            "around"                => 25,
            "single_passage"        => false,
            "exact_phrase"          => false
        );
        $films = $this->BuildExcerpts($films,$keyword,$opts);

        //得到关键词分词结果
        if(isset($res['words'])){
            $res['words'][$keyword] = $keyword;
            $words = array_keys($res['words']);
        }

        return array(
            'films'=>$films,
            'total'=>$res['total'],
            'words'=>$words
        );
    }

    public function initSphinxClient($limits,$sort = SPH_SORT_TIME_SEGMENTS)
    {
        $sphinx = new SphinxClient ();
        $sphinx->SetServer($this->sphinxServer,$this->sphinxPort);
        $sphinx->SetConnectTimeout ( 3 );


        $sphinx->SetLimits($limits['offset'],$limits['num']);
        $sphinx->SetFilter('status',array(1));
        $sphinx->SetArrayResult ( true );
        $sphinx->SetMatchMode (SPH_MATCH_ALL);

        if(is_array($sort)){
            $sphinx->SetSortMode($sort[0],$sort[1]);
        }else{
            $sphinx->SetSortMode($sort);
        }
        return $sphinx;
    }

    /**
     * 处理sphinx的返回结果
     */
    private function prepareSphinxResult($result)
    {
        if( ! isset($result['matches'])) return false;
        //$result = arraySort($result['matches'], 'weight', 'desc');
        $filmIds = [];
        foreach($result['matches'] as $key => $value)
        {
            $filmIds[] = $value['id'];
        }
        return $filmIds;
    }

    private function filmsSort($films,$sphinxRes){
        $filmsIdArray = [];
        foreach($films as $value){
            $filmsIdArray[$value['id']] = $value;
        }
        if(count($filmsIdArray) < 1){
            return false;
        }
        $res = [];
        foreach($sphinxRes as $key=>$value){
            $res[$key] = $filmsIdArray[$value];
            //isset($filmsIdArray[$value]) ? $res[$key] = $filmsIdArray[$value] : '';
        }

        return $res;
    }

    private function BuildExcerpts ($films,$words,$opts=array() ){
        $docs_content = [];
        $docs_title = [];
        foreach($films as $film){
            $docs_content[$film->id] = strip_tags($film->content);
            $docs_title[$film->id] = $film->title;
        }

        $contet_res = $this->sphinx->BuildExcerpts ( $docs_content,$this->sphinxIndex,$words, $opts );
        $title_res = $this->sphinx->BuildExcerpts ( $docs_title,$this->sphinxIndex,$words, $opts );

        foreach($films as $key=>$film){
            $films[$key]->content = $contet_res[$film->id];
            $films[$key]->highlightTitle = $title_res[$film->id];
        }
        return $films;
    }


}