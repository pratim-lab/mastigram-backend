<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductShipping extends Model
{
    protected $table = 'product_shippings';

    protected $guarded = [];

    public function shipping_method(){
        return $this->belongsTo('App\Model\ShippingMethod', 'shipping_method_id');
    }
}
