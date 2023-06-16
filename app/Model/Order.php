<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    public function order_detail() {
        return $this->hasMany('App\Model\OrderDetail','order_id')->orderBy('id','ASC');
    }

    public function order_detail_site() {
        return $this->hasMany('App\Model\OrderDetail','order_id')->orderBy('id','ASC');
    }

    public function order_detail_admin() {
        return $this->hasMany('App\Model\OrderDetail','order_id')->orderBy('id','ASC');
    }

    public function order_coupon_data() {
        return $this->hasOne('App\Model\AppliedCoupon','order_id');
    }

    public function order_currency() {
        return $this->hasOne('App\Model\OrderCurrency','order_id');
    }
	
	public function order_user() {
		return $this->belongsTo('App\Model\User', 'user_id');
    }
	public function order_category() {
		return $this->belongsTo('App\Model\Category', 'cart_category_id');
    }
}