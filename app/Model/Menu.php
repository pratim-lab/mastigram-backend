<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $guarded = [];

    public function Category()
  {
     return $this->belongsTo('App\Model\Category', 'category_id');
  }

  public function menu_links(){
      return $this->hasMany('App\Model\MenuLink', 'menu_id');
    }

}
