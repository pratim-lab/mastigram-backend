<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PriceBand extends Model
{
    protected $table = 'price_bands';

    protected $guarded = [];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }
}
