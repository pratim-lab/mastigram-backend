<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
    protected $table = 'discount_products';

    public $timestamps = false;

    protected $guarded = [];
}