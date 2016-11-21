<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl;

/**
 * 用户列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class User extends AbstractBase
{
    /**
     * 用户列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('user', 'edit', 'foundation')->setData($data)->checkPermission(Acl::GROUP_LEVEL_TYPE_USER);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id']) ]);
        $html = $this->hasPermission ?
                    '<a class="ajaxModal" href="'.$url.'" data-toggle="modal" data-target="#ajaxModal"><i class="fa fa-pencil"></i>编辑</a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 用户列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('user', 'delete', 'foundation')->setData($data)->checkPermission(Acl::GROUP_LEVEL_TYPE_USER);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="' . $url . '" class="ajax-delect" data-tips="确定删除吗?"><i class="fa fa-trash-o"></i>删除</a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 用户列表权限操作
     *
     * @access public
     */
    public function acl($data)
    {
        $this->setCurrentAction('acl', 'user', 'foundation')->setData($data)->checkPermission(Acl::GROUP_LEVEL_TYPE_USER);
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
            '<a href="'.$url.'" class="layer-iframe"><i class="fa fa-user"></i>授权</a>'
            : '<i class="fa fa-user" style="color:#ccc"></i>';
        return $html;
    }

}