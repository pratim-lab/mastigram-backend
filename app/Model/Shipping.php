<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shippings';

    protected $guarded = [];
	
	public function shippingZone(){
    	return $this->belongsTo('App\Model\PincodeGroup', 'shipping_zone');
    }
	public function shippingMethod(){
    	return $this->belongsTo('App\Model\ShippingMethod', 'shipping_method_id');
    }
	
}
