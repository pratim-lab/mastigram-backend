<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductExtraAddonGroupRelation extends Model
{
    protected $table = 'product_extra_addon_group_relations';

    public $timestamps = false;

    protected $guarded = [];
}