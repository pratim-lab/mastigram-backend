<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    public function CouponUser (){
        return $this->hasMany('App\Model\CouponUser');
  	}

  	public function CouponOccation (){
        return $this->hasMany('App\Model\CouponOccation');
  	}

  	protected $guarded = [];
}