<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    protected $table = 'combos';

    protected $guarded = [];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }
}
