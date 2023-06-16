<?php

namespace App\Helpers;

use Request;

class CustomPaginator
{
    public static function sort($field, $text, $arr = [])
    {
    	if(Request::query('sort')){
	    	if(Request::query('sort') == $field && Request::query('direction') == 'desc'){
	    		$direction = 'asc';
	    		$icon_position = 'up';
	    	}else{
				$direction = 'desc';
				$icon_position = 'down';
	    	}
	    }else{
	    	$direction = 'desc';
	    	$icon_position = 'down';
	    }
    	$direction_icon = '<i class="fas fa-angle-'.$icon_position.'"></i>';
    	if(!empty($arr)){

    		$direction_needed = (isset($arr['direction']) && !$arr['direction']) ? $arr['direction'] : true;

    		if($direction_needed){
    			$direction_icon = '<i class="fas fa-angle-'.$icon_position.'"></i>';
    		}else{
    			$direction_icon = '';
    		}
    	}
    	return '<a href="'.Request::fullUrlWithQuery(["sort" => $field, 'direction' => $direction]).'">'.$text.$direction_icon.'</a>';
    }
}
