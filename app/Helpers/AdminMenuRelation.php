<?php

namespace App\Helpers;

use Request;

class AdminMenuRelation
{
    public static function generateTree($arr = [])
    {
        $tree = '';
        foreach($arr as $tree_data){
            $tree .= '<li>';
            $tree .=    '<a href="javascript:void(0)">';
            $tree .=        $tree_data->taxonomy->title;
            $tree .=     '</a>';
            $tree .=     self::generateTree($tree_data->childrenRecursive);
            $tree .= '</li>';
        }
        if(!empty($tree)){
            $tree = '<ul>'.$tree.'</ul>';
        }
        return $tree;
    }

    public static function getArray($arr = [], $notIn = [])
    {
        $tree = [];
        $arr = $arr->whereNotIn('id', $notIn);
        foreach($arr as $tree_data){
            $tree[$tree_data->id] = $tree_data->taxonomy->title;
            $tree += self::getArray($tree_data->childrenRecursive, $notIn);
        }
        return $tree;
    }
}
