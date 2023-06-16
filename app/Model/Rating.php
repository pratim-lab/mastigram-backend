<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $guarded = [];

    public function user_data(){
    	return $this->belongsTo('App\Model\User', 'user_id')->select('id','name');
    }

}
