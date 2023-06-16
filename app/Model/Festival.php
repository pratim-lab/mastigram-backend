<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    protected $table = 'festivals';

    protected $guarded = [];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }
}
