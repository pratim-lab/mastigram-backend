<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $table = 'taxonomies';

    protected $guarded = [];

    public function category(){
    	return $this->hasOne('App\Model\Category', 'taxonomy_id');
    }

    public function occasion(){
    	return $this->hasOne('App\Model\Occasion', 'taxonomy_id');
    }
}
