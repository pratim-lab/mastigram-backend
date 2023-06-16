<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = 'relations';

    protected $guarded = [];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }
}
