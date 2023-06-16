<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuickLinkMenu extends Model
{
    protected $table = 'quicklink_menus';

    protected $guarded = [];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }
}
