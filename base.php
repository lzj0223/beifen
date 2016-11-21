<?php
defined('APP_ROOT') || define('APP_ROOT', dirname(__FILE__));
require_once APP_ROOT.'/Core/Db.php';
require_once APP_ROOT.'/Core/Logger.php';
require APP_ROOT.'/Core/vendor/autoload.php';
use QL\QueryList;

class Base{
    static $curl;
    static $db;
    protected $params;

    /*protected $db_conf = array(
        'host'=>'115.28.27.73',
        'user'=>'btfilm',
        'pass'=>'123456',
        'port'=>'3306',
        'dbName'=>'btfilm',
    );*/
    protected $db_conf = array(
        'host'=>'localhost',
        'user'=>'lzhj',
        'pass'=>'yzl.520',
        'port'=>'3306',
        'dbName'=>'btfilm',
    );

    public function __construct() {
        if(!self::$db){
            $this->getDb();
        }
        if(!self::$curl){
            $this->setCurl();
        }
    }

    public function fuck($site){
        $params = [];
        foreach($site as $key=>$value){
            $value['list_reg'] = $this->isJson($value['list_reg']);
            $value['content_reg'] = $this->isJson($value['content_reg']);
            $value['page_reg'] = $this->isJson($value['page_reg']);
            $list_url = $value['list_url'] ? $value['list_url'] : $value['site_url'];
            $this->addTask($list_url,array($this,'gather_callback_list'),false);
            $params[$value['site_url']] = $value;
        }
        $this->params = $params;
    }

    protected function addTask($urls,$success = false,$error = false,$args = []){
        self::$curl->add($urls,$success,$error,$args);
    }

    public function start(){
        self::$curl->start();
    }

    protected function  isJson($str){
        $res = json_decode($str,true);
        return is_null($res) ? $str :$res;
    }

    public function get_film_site_url($condition = array()){
        $condition['status'] = 1;
        $list = self::$db->where($condition)->select('db_film_site');
        return $list;
    }

    protected function getDb(){
        $db = new Db($this->db_conf);
        /*$sql = "set interactive_timeout=24*2*3600";

        $db->doSql($sql);
        var_dump($sql);exit();*/
        return self::$db = $db;
    }

    /**
     * 保存文章链接，并检测该链接是否已经采集过
     * @param $url
     * @return bool
     */
    protected function save_film_links($url){
        $url = trim($url,'/');
        Logger::log($url,'url');

        $sql = "INSERT IGNORE db_gather_url(`hash_unique`,`gahter_url`) VALUES(crc32(concat('{$url}',1)),'{$url}')";
        $is_exit = $this->doSql($sql);
        if($is_exit == false || $is_exit < 1){
            return false;
        }
        return true;
    }

    /**
     * 检测资源链接类型
     * @param $link
     * @param $site_url
     * @return string
     */
    protected function chekcSourceLinks($link,$site_url,$cur_url=''){
        if(!$link){
            Logger::log("error:{$link}",'film_source_error');
            return false;
        }
        if(strstr($link,'magnet:') || strstr($link,'thunder://') || strstr($link,'http') || strstr($link,'ed2k://') || strstr($link,'ftp:')){
            $url = $link;
        }elseif(strstr($link,'javascript:')){
            Logger::log("error:{$link}",'film_source_error');
            return false;
        }else{
            $url =  $this->check_links($link,$site_url,$cur_url);
        }
        return $url;
    }

    /**
     * 补全链接
     * @param $content 需要处理的相对链接
     * @param $siteUrl 网站网址
     * @param $args  其为数组时，是Multi的成功时的回调函数参数；否则，是当前的网址链接
     * @return string
     */
    protected function check_links($content,$siteUrl,$args){
        $siteUrl = rtrim($siteUrl,'/');
        $url = is_array($args) ? $args[0]['info']['url'] : $args;
        $baseUrl = '';
        if(!strstr($content,'http')){
            if(substr($content,0,1) != '/'){
                $i = strrpos($url,'/');
                $baseUrl = $i === false ?  '/' : substr($url,0,$i+1);
            }
            $content = $baseUrl.$content;
        }
        return strstr($content,'http') ? $content : $siteUrl.$content ;
    }

    protected function doSql($sql){
        Logger::log($sql,'db_action');
        try{
            return self::$db->doSql($sql);
        }catch (Exception $e){
            self::$db->close();
            self::$db = $this->getDb();
            Logger::log($sql,'dbaction_error');
            return false;
        }
    }

    public function setCurl(){
        self::$curl = QueryList::run('Multi',[
            //'list' => $urls,
            'curl' => [
                'opt' => array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                    CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 UBrowser/5.5.6125.14 Safari/537.36'
                ),
                //设置线程数
                'maxThread' => 100,
                //设置最大尝试数
                'maxTry' => 3
            ],
            //'success' => $success_callback_func,
            'error' => function($a){
                Logger::log('error:'.json_encode($a),'gather_error');
            },
            'start'=>false
        ]);
    }

    public function gather_callback_list(){
        $args = func_get_args();
        echo $args[0]['info']['url'],"\n";
        preg_match('/^(https?:\/\/)?[\d\w]{0,}\.?[\d\w]+\.\w+\/?/i',$args[0]['info']['url'],$baseUrl);
        $baseUrl[0] = rtrim($baseUrl[0],'/');
        $list_reg = $this->params[$baseUrl[0]]['list_reg'];
        $page_reg = $this->params[$baseUrl[0]]['page_reg'];
        $gather_action = $this->params[$baseUrl[0]]['gather_action'] ? $this->params[$baseUrl[0]]['gather_action'] : 'gather_callback_content';
        $charset = $this->params[$baseUrl[0]]['charset'];

        if(strtolower($charset) != 'utf-8'){
            $args[0]['content'] = mb_convert_encoding($args[0]['content'],'utf-8',strtolower($charset));
        }

        $reg = [
            'link' => [$list_reg['url'][0],$list_reg['url'][1],'',function($content)use($baseUrl){
                //利用回调函数补全相对链接
                return strstr($content,'http') ? $content : $baseUrl[0].'/'.ltrim($content,'/');
            }],
            'title'=>$list_reg['title']
        ];


        $ql = QueryList::Query($args[0]['content'],$reg,'');
        $data = $ql->getData();
        foreach($data as $key=>$value){
            if(!$this->save_film_links($value['link'])){
                unset($data[$key]);
                continue;
            }
            self::$curl->add($value['link'],array($this,$gather_action),false,array('title'=>$value['title']));
        }

        if(is_array($data)&&count($data) > 0){
            $page = QueryList::Query($args[0]['content'],['page'=>[$page_reg[0],$page_reg[1],'',function($content)use($baseUrl,$args){
                return $this->check_links($content,$baseUrl[0],$args);
            }]])->getData();

            if($page[0]['page']){
                self::$curl->add(array($page[0]['page']),array($this,'gather_callback_list'));
            }else{
                echo "no next page \n";
            }
        }else{
            echo "no data \n";
        }
    }

    public function insertFilm($sources,$args,$content,$site_info){
        $search_index_content = strip_tags($content);
        $search_index_content = preg_replace("/\s{2,}/"," ",$search_index_content);
        $search_index_content = preg_replace("/[\r\n]+/"," ",$search_index_content);
        $summary = mb_substr($search_index_content,0,300);
        if(count($sources) > 0){
            $film_data = array(
                'site_id'=>$site_info['id'],
                'title'=>$args[1][1]['title'],
                'content'=>$content,
                'status'=>1,
                'summary'=>$summary,
                'gather_url'=>$args[0]['info']['url'],
                'c_time'=>date('Y-m-d H:i:s',time()),
            );

            $film_id = self::$db->insert('db_film',$film_data,1);
            if($film_id){
                foreach($sources as $key=>$value){
                    $sources_data['film_id'] = $film_id;
                    $sources_data['link'] = $value;
                    self::$db->insert('db_film_source',$sources_data);
                }
                self::$db->insert('db_film_search_index',array(
                    'id'=>$film_id,
                    'content'=>$args[1][1]['title'].' '.$search_index_content,
                    'status'=>1,
                    'site_id'=>$site_info['id'],
                    'c_time'=>$film_data['c_time'],
                ));
            }else{
                $msg = "insert content error:[sql:". self::$db->getLastSql() .",url:{$args[0]['info']['url']}]";
                Logger::log($msg,'content_error');
            }
        }else{
            Logger::log("no sources,url:{$args[0]['info']['url']}",'sources');
        }
    }
}


