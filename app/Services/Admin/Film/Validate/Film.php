<?php namespace App\Services\Admin\Film\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Film extends BaseValidate
{
    /**
     * 增加文章的时候的表单验证
     *
     * @access public
     */
    public function add(\App\Services\Admin\Film\Param\FilmSave $data)
    {
        // 创建验证规则
        $rules = array(
            'title' => 'required',
            'summary' => 'required',
            //'user_id' => 'required',
            'content' => 'required',
            'status' => 'required',
        );
        
        // 自定义验证消息
        $messages = array(
            'title.required' => Lang::get('film.title_empty'),
            'summary.required' => Lang::get('film.summary_empty'),
            //'user_id.required' => Lang::get('film.user_id_empty'),
            'content.required' => Lang::get('film.content_empty'),
            'status.required' => Lang::get('film.status_empty')
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
    public function edit(\App\Services\Admin\Film\Param\FilmSave $data)
    {
        return $this->add($data);
    }
    
}
