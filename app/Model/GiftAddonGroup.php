<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GiftAddonGroup extends Model
{
    protected $table = 'gift_addon_groups';

    protected $guarded = [];

    public function relatedgroupdetails() {
    	return $this->hasMany('App\Model\GiftAddonGroupRelation', 'gift_addon_group_id');
    }
}