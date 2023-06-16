<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SideMenu extends Model
{
    protected $table = 'side_menus';

    protected $guarded = [];

    public function Category()
  {
     return $this->belongsTo('App\Model\Category', 'category_id');
  }

  public function menu_links(){
      return $this->hasMany('App\Model\SideMenuLink', 'menu_id');
    }

}
