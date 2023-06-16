<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DiscountUserGroup extends Model
{
    protected $table = 'discount_usergroups';

    public $timestamps = false;

    protected $guarded = [];
}