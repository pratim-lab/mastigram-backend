<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DiscountBrand extends Model
{
    protected $table = 'discount_brands';

    public $timestamps = false;

    protected $guarded = [];
}