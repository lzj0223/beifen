<?php

namespace App\Widget\Admin;

use App\Services\Admin\Acl\Acl;

/**
 * 小组件
 *
 * @author jiang <mylampblog@163.com>
 */
Abstract class AbstractBase
{
    /**
     * 权限处理类对象
     *
     * @var object
     */
    protected $acl;

    /**
     * 传入过来的数据
     * 
     * @var array
     */
    protected $data;

    /**
     * 当前module
     * 
     * @var string
     */
    protected $module;

    /**
     * 当前class
     * 
     * @var string
     */
    protected $class;

    /**
     * 当前function
     * 
     * @var string
     */
    protected $function;

    /**
     * 标识是否有权限
     *
     * @var boolean
     */
    protected $hasPermission;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->acl = new Acl();
    }

    /**
     * 设置当前请求的module,class,function
     *
     * @param string $class 类
     * @param string $function 函数
     * @param string $module 模块
     * @access public
     * @return object $this
     */
    public function setCurrentAction($class, $function, $module = '')
    {
        $this->module = $module;
        $this->class = $class;
        $this->function = $function;
        return $this;
    }

    /**
     * 设置传进来的额外的数据
     * 
     * @param array $data
     * @return object $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 检测是否有权限
     *
     * @param string $type 取值为Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP
     * @access protected
     */
    protected function checkPermission($type = NULL)
    {
        $this->hasPermission = $this->acl->checkIfHasPermission($this->module, $this->class, $this->function);
        if(isset($this->data['id']) && in_array($type, [Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP])
            && ! $this->acl->checkGroupLevelPermission($this->data['id'], $type))
                $this->hasPermission = false;
    }

    /**
     * 批量删除按钮
     *
     * @access public
     */
    protected function deleteSelectBtn($url = '#',$msg='批量删除',$group='select-delete-group')
    {
        $html = $this->hasPermission ?
            '<div class="btn-group btn-group-sm">
              <a target="_self" title="'.$msg .'" href="'. $url . '" class="btn btn-primary select-delete" data-group="'. $group .'"><i class="fa fa-trash-o"></i>  批量删除</a></div>'
            : '';
        return $html;
    }

    /**
     * 编辑操作按钮
     * @access public
     */
    protected function editBtn($url,$msg='编辑',$ajaxModal= false)
    {
        $url = $url ? $url : R('common', $this->module.'.'.$this->class.'.'.$this->function);
        if($ajaxModal){
            $html = $this->hasPermission ?
                '<a class="ajaxModal" data-toggle="modal" data-target="#ajaxModal" href="'.$url.'" title="'.$msg.'"><i class="fa fa-pencil"></i></a>'
                : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        }else{
            $html = $this->hasPermission ?
                '<a class="layer-iframe" target="_self" href="'.$url.'" title="'.$msg.'"><i class="fa fa-pencil"></i></a>'
                : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        }
        return $html;
    }

    /**
     * 删除操作按钮
     *
     * @access public
     */
    protected function deleteBtn($url,$msg='删除',$tips='确定删除吗?')
    {
        $url = $url ? $url : R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
            '<a class="ajax-delect" target="_self" data-tips="'. $tips .'" title="'.$msg.'" href="'.$url.'"><i class="fa fa-trash-o"></i></a>'
            : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 新增按钮
     *
     * @access public
     */
    public function addBtn($url='',$msg='新增',$ajaxModal= false)
    {
        $url = $url ? $url :  R('common', $this->module.'.'.$this->class.'.'.$this->function);
        if($ajaxModal){
            $html = $this->hasPermission ?
                '<button class="btn btn-info btn-xs ajaxModal" data-url="'. $url  .'" data-toggle="modal" data-target="#ajaxModal" type="button"><i class="fa fa-paste"></i> '. $msg.'</button>'
                :'<i class="fa fa-pencil" style="color:#ccc"></i>';
        }else{
            $html = $this->hasPermission ?
                '<button class="btn btn-info btn-xs layer-iframe" data-url="'. $url  .'" type="button"><i class="fa fa-paste"></i> '. $msg.'</button>'
                : '';
        }
        return $html;
    }

}