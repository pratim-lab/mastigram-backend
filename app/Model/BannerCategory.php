<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class BannerCategory extends Model
{
    protected $table = 'banner_categories';

    protected $guarded = [];

    /*public function banner() {
    	return $this->hasMany('App\Model\Banner', 'banner_categories_id')->where('is_block','N')->take(1)->orderBy('id','DESC');
    }*/
}
