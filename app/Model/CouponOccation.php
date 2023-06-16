<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CouponOccation extends Model
{
    protected $table = 'coupon_occations';

    public $timestamps = false;

    protected $guarded = [];
}