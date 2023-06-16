<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    protected $table = 'quicklinks';

    protected $guarded = [];

    public function quick_link_menu(){
    	return $this->hasMany('App\Model\QuickLinkMenu', 'quick_link_id')->orderBy('sort', 'asc');
    }
}
