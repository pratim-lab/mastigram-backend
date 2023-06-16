<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageCatalog extends Model
{
    protected $table = 'images_catalog';

    protected $guarded = [];

    /*public function BannerCategory() {
    	return $this->belongsTo('App\Model\BannerCategory', 'banner_categories_id');
    }*/
}
