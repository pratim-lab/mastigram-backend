<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    
    const UPDATED_AT = null;
    
    protected $guarded = [];
    
    public function country() {
    	return $this->belongsTo('App\Model\Country','country_id');
	}

	public function State(){
    	return $this->belongsTo('App\Model\State','state_id');
	}

	public function city_group_relation(){
        return $this->hasMany('App\Model\CityGroupRelation', 'cities_id');
    }

    public function cityurl_links(){
        return $this->hasMany('App\Model\CityLink', 'city_id');
    }

    public function falseurl_sort_order(){
        return $this->belongsTo('App\Model\FalseurlProductSortorder', 'sort_order');
    }
}