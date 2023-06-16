<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CouponUserGroup extends Model
{
    protected $table = 'coupon_usergroups';

    public $timestamps = false;

    protected $guarded = [];
}