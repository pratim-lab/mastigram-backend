<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    protected $table = 'delivery_options';

    protected $guarded = [];

    /*public function shippingMethod (){
        return $this->belongsTo('App\Model\ShippingMethod');
  	}*/

  	public function delivery_option_links(){
    	return $this->hasMany('App\Model\DeliveryOptionsLink', 'delivery_options_id');
    }
}
