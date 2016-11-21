<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;

/**
 * 电影列表小组件
 */
class FilmContent extends AbstractBase
{
    /**
     * 电影列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('content', 'edit', 'film')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $this->editBtn($url);
        return $this->editBtn($url);
    }

    /**
     * 电影列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('content', 'delete', 'film')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        return $this->deleteBtn($url);
    }

    /**
     * 新增电影的按钮
     *
     * @access public
     */
    public function add()
    {
        $this->setCurrentAction('content', 'add', 'film')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        return $this->addBtn($url);
    }

    /**
     * 批量删除
     *
     * @access public
     */
    public function deleteSelect()
    {
        $this->setCurrentAction('content', 'delete', 'film')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        return $this->deleteSelectBtn($url);
    }

}