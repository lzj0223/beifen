<?php

namespace App\Widget\Home;
use App\Services\Home\Search\Process;
/**
 * 小组件
 */
class Search
{

    public function sortMenu($sort,$keyword){
        $sphinxSortModel = (new Process())->sphinxSortModel;

        if(!isset($sphinxSortModel[$sort])){
            $sort = 2;
        }

        $html = '';
        foreach($sphinxSortModel as $key=>$value){
            if($key == $sort){
                $decoration = $key == $value[2] ? '' : ($key < $value[2] ? 'down' : 'up' );
                $html .= '<a href="?sort='.$value[2].'&search='.$keyword.'" class="curr '.$decoration.'">'.$value[3].'<i></i></a>';
            }elseif(($value[2] != $sort && $key <= $value[2])){
                $html .= '<a href="?sort='.$value[2].'&search='.$keyword.'">'.$value[3].'<i></i></a>';
            }
        }
        return $html;
    }
}