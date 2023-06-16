<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class PincodeGroup extends Model
{
    protected $table = 'pincode_groups';
    
    protected $guarded = [];
    
    public function relatedgroupdetails() {
        return $this->hasMany('App\Model\PincodeGroupRelation', 'pincode_group_id');
    }
}