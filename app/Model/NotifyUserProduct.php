<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NotifyUserProduct extends Model
{
    protected $table = 'notify_user_product';

    protected $guarded = [];

	public function notifiedUsers(){
		return $this->belongsTo('App\Model\User', 'user_id');
    }
    public function product(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

   /*  public function scopeBalanceType($query, $id)
    {
        return $query->where('balace_type',$id);
    }
    public function scopeBlockType($query, $id)
    {
        return $query->where('is_block',$id);
    } */
}
