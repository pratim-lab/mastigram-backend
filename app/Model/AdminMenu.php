<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $table = 'admin_menus';

    protected $guarded = [];
  
    public function Methods(){
    	return $this->hasMany('App\Model\AdminMenu', 'parent_id');
    }
}
