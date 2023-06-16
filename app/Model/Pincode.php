<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $table = 'pincodes';
    
    protected $guarded = [];
    
    public function country() {
    	return $this->belongsTo('App\Model\Country','country_id');
	}

	public function state(){
    	return $this->belongsTo('App\Model\State','state_id');
	}

	public function city(){
    	return $this->belongsTo('App\Model\City','city_id');
	}

    public function pincode_group_relation(){
        return $this->hasMany('App\Model\PincodeGroupRelation', 'pincode_id');
    }
}