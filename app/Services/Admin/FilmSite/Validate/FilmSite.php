<?php namespace App\Services\Admin\FilmSite\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 表单验证
 */
class FilmSite extends BaseValidate
{
    /**
     * 增加文章的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\FilmSite\Param\FilmSiteSave $data)
    {
        // 创建验证规则
        $rules = array(
            'site_name' => 'required',
            'site_url' => 'required',
        );
        
        // 自定义验证消息
        $messages = array(
            'site_name.required' => Lang::get('filmsite.site_name_empty'),
            'site_url.required' => Lang::get('filmsite.site_url_empty'),
        );
        
        //开始验证
        $validator = Validator::make($data->toArray(), $rules, $messages);
        if($validator->fails())
        {
            $this->errorMsg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
    /**
     * 编辑电影的时候的表单验证
     *
     * @access public
     */
    public function edit(\App\Services\Admin\FilmSite\Param\FilmSiteSave $data)
    {
        return $this->add($data);
    }
    
}
