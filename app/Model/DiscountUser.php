<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DiscountUser extends Model
{
    protected $table = 'discount_users';

    public $timestamps = false;

    protected $guarded = [];
}