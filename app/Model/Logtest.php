<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Logtest extends Model
{
    protected $table = 'logtest';

    protected $guarded = [];
	
	public function user() {
    	return $this->belongsTo('App\Model\User', 'user_id');
    }
}
