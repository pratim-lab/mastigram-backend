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
        
      public function CouponBrand (){
            return $this->hasMany('App\Model\CouponBrand');
      }
      public function CouponUserGroup (){
            return $this->hasMany('App\Model\CouponUserGroup');
      }
      public function CouponCategory (){
            return $this->hasMany('App\Model\CouponCategory');
      }

      public function CouponProduct (){
            return $this->hasMany('App\Model\CouponProduct');
      }

  	protected $guarded = [];
}