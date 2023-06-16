<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    
    const UPDATED_AT = null;
    
    protected $guarded = [];
    
    public function Country(){
    	return $this->belongsTo('App\Model\Country','country_id');
	}
}