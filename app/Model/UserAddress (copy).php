<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ProductRelatedGiftAddonGroup extends Model
{
    protected $table = 'product_related_gift_addon_groups';

    protected $guarded = [];

    /*public function gift_addons(){
        return $this->hasOne('App\Model\GiftAddonGroupRelation', 'gift_addon_group_id');
    }*/
    
}