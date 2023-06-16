<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryTiming extends Model
{
    protected $table = 'delivery_timings';

    protected $guarded = [];

    public function shippingMethod (){
        return $this->belongsTo('App\Model\ShippingMethod');
  	}
}
