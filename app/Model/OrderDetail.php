<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    
    protected $guarded = [];

  	public function product() {
    	return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function order_related_detail() {
        return $this->hasOne('App\Model\OrderDetail', 'order_details_id');
    }

    public function product_attribute_detail() {
        return $this->belongsTo('App\Model\ProductAttribute', 'product_attr_id');
    }

    public function gift_addon_detail() {
        return $this->belongsTo('App\Model\GiftAddon', 'gift_addon_id');
    }

    public function order_voloum_price() {
        return $this->hasMany('App\Model\ProductVolume', 'product_id','product_id');
    }
     public function order_assign_voloum_price() {
        return $this->hasOne('App\Model\OrderDetailsVoloumPrice', 'order_details_id');
    }

}