<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    protected $table = 'related_products';

    protected $guarded = [];

    public function relatedproductdetails() {
    	return $this->belongsTo('App\Model\Product', 'related_product_id')->where([['status','A'],['is_deleted','N']]);
    }
}