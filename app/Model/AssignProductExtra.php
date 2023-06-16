<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssignProductExtra extends Model
{
    protected $table = 'assign_product_extras';

    protected $guarded = [];

    public function productextra(){
    	return $this->belongsTo('App\Model\ProductExtra', 'product_extras_id');
    }
}