<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    protected $table = 'holdings';

    protected $guarded = [];

    // public function product(){
    // 	return $this->belongsTo('App\Model\Product', 'product_id');
    // }

   /*  public function scopeBalanceType($query, $id)
    {
        return $query->where('balace_type',$id);
    }
    public function scopeBlockType($query, $id)
    {
        return $query->where('is_block',$id);
    } */
}
