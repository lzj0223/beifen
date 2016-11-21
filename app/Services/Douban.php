<?php
namespace App\Services;
use App\Libraries\Snoopy as Snoopy;
use Cache;
class Douban{
	private $list_api_url = 'https://movie.douban.com/j/search_subjects?type=movie&tag={tag}&sort={sort}&page_limit=20&page_start={page_start}';
	private $detail_api_url = 'https://movie.douban.com/subject/{id}/';
	private $photos_api = 'https://movie.douban.com/subject/{id}/photos?type={type}';
	private $rank_api = 'https://movie.douban.com/';
	static $sort_type = array('recommend','time','rank');
	static $tag = array('热门','最新','经典','可播放','豆瓣高分','冷门佳片','华语','欧美','韩国 日本','动作','喜剧','爱情','科幻','悬疑','恐怖','文艺');
	static $photos_type = ['S'=>'剧照',];

	public $error = '';
	public $last_request_url = '';
	
	public function get_list($page_start=0,$sort_type=0,$tag=0,$return_json = 0){
		$sort_type = is_numeric($sort_type) ? self::$sort_type[$sort_type] : $sort_type;
		if (!in_array($sort_type,self::$sort_type)){
			$this->error = 'sort_tye is error';
			return false;
		}
		$tag = is_numeric($tag) ? self::$tag[$tag] : $tag;
		if (!in_array($tag,self::$tag)){
			$this->error = 'tag is error';
			return false;
		}
		
		$list_api_url = str_replace(array('{tag}','{sort}','{page_start}'),array($tag,$sort_type,$page_start),$this->list_api_url);
		$res = Cache::get($list_api_url);

		if (!$res){
			$res = $this->_request($list_api_url);
			if ($res === false){
				return false;
			}
			//缓存时间一天
			Cache::put($list_api_url,$res, 1440);
		}

		return $return_json ?  $res :json_decode($res,true);
	}

	public function get_detail($id){
		$detail_api_url = str_replace('{id}',$id,$this->detail_api_url);
		$res = Cache::get($detail_api_url);
		if (!$res){
			$html = $this->_request($detail_api_url);
			if ($html === false){
				return false;
			}

			$res = \QL\QueryList::Query($html ,[
				'info'=>['#info','html','a'],
				'mainpic'=>['#mainpic > a > img','src'],
				'interest_sectl'=>['#interest_sectl','html','a'],
				'detail'=>['.related-info','html','a'],
				'title'=>['h1','text'],
			])->getData();
			//缓存时间一周
			Cache::put($detail_api_url,$res, 10080);
		}
		return $res[0];
	}

	public function get_rank(){
		$res = Cache::get('douban_rank');
		if (!$res){
			$html = $this->_request($this->rank_api);
			if ($html === false){
				return false;
			}
			$res = \QL\QueryList::Query($html ,[
				'order'=>['.billboard-bd > table > tr > td.order','text'],
				'title'=>['.billboard-bd > table > tr > td.title','text'],
				'id'=>['.billboard-bd > table > tr > td.title > a','href','',function($content){
					preg_match('/(\d+)/',$content,$r);
					return $r[1];
				}],
			])->getData();
			//缓存时间一天
			Cache::put('douban_rank',$res, 1440);
		}

		return $res;
	}

	public function get_photos($id,$type){
		$photos_api = str_replace(array('{id}','{type}'),array($id,$type),$this->photos_api);
		$res = Cache::get($photos_api);
		if (!$res){
			$html = $this->_request($photos_api);
			if ($html === false){
				return false;
			}
			$res = \QL\QueryList::Query($html ,[
				'src'=>['.poster-col4 > li > div.cover > a >img','src'],
			])->getData();
			//缓存时间一周
			Cache::put($photos_api,$res, 10080);
		}
		return $res;
	}
	
	

	private function _request($url,$data = array(),$method = 'get'){
		$snoopy = new  Snoopy();
		$snoopy->fetch($url);

		$this->last_request_url = $url;
		if ($snoopy->error != ''){
			$this->error = $snoopy->error;
			return false;
		}
		return $snoopy->results;
	}
}