<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminPermision extends Model
{
    protected $table = 'admin_permisions';

    protected $guarded = [];

    public function admin_menu(){
    	return $this->belongsTo('App\Model\AdminMenu', 'menu_id');
    }
}
