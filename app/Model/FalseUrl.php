<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FalseUrl extends Model
{
    protected $table = 'false_urls';

    protected $guarded = [];

    public function Category()
	{
	   return $this->belongsTo('App\Model\Category', 'category_id');
	}

	public function falseurl_links(){
    	return $this->hasMany('App\Model\FalseurlLink', 'falseurl_id');
    }

    public function falseurl_sort_order(){
    	return $this->belongsTo('App\Model\FalseurlProductSortorder', 'sort_order');
    }

}