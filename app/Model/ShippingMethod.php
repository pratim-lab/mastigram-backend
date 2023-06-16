<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    protected $guarded = [];

    public function delivery_timing(){
        return $this->hasMany('App\Model\DeliveryTiming', 'shipping_method_id');
    }
}
