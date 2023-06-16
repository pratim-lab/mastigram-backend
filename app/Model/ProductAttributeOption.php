<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    protected $table = 'product_attribute_options';

    protected $guarded = [];
	
	public function attr(){
        return $this->belongsTo('App\Model\Attribute', 'attribute_id')->select('id','title','attr_slug');
    }
}
