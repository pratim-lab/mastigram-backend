<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $table = 'coupon_users';

    public $timestamps = false;

    protected $guarded = [];
}