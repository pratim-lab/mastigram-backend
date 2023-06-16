<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DiscountCategory extends Model
{
    protected $table = 'discount_categories';

    public $timestamps = false;

    protected $guarded = [];
}