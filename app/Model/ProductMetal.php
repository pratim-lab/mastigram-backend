<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductMetal extends Model
{
    use SoftDeletes;
    protected $table = 'product_metal';

    protected $guarded = [];

    public $timestamps = true;

    

}