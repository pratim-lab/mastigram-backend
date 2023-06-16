<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    protected $table = 'coupon_categories';

    public $timestamps = false;

    protected $guarded = [];
}