<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CityGroup extends Model
{
    protected $table = 'city_groups';

    protected $guarded = [];

    public function relatedgroupdetails() {
    	return $this->hasMany('App\Model\CityGroupRelation', 'city_group_id');
    }
}