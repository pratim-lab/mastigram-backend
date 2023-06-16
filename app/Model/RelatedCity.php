<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class RelatedCity extends Model
{
    protected $table = 'product_related_cities';

    protected $guarded = [];

    public function cityrelatedproductdetails() {
    	return $this->belongsTo('App\Model\Product','product_id')->where([['status','A'],['is_deleted','N']]);
    }
}