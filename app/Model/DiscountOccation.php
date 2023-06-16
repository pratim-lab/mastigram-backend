<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class DiscountOccation extends Model
{
    protected $table = 'discount_occations';

    public $timestamps = false;

    protected $guarded = [];
}