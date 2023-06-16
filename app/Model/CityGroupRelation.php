<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CityGroupRelation extends Model
{
    protected $table = 'city_group_relations';

    public $timestamps = false;

    protected $guarded = [];

    /*public function relatedproductdetails() {
    	return $this->belongsTo('App\Model\Product', 'related_product_id')->where([['status','A'],['is_deleted','N']]);
    }*/
}