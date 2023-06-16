<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CouponBrand extends Model
{
    protected $table = 'coupon_brands';

    public $timestamps = false;

    protected $guarded = [];
}