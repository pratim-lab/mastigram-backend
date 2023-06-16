<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    protected $guarded = [];

    public function country() {
    	return $this->belongsTo('App\Model\Country', 'country_id');
    }

    public function state() {
    	return $this->belongsTo('App\Model\State', 'state_id');
    }

    public function city() {
    	return $this->belongsTo('App\Model\City', 'city_id');
    }

}