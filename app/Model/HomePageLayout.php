<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class HomePageLayout extends Model
{
    protected $table = 'home_page_layout';

   //  public function DiscountUser (){
   //      return $this->hasMany('App\Model\DiscountUser');
  	// }

  	// public function DiscountOccation (){
   //      return $this->hasMany('App\Model\DiscountOccation');
   //      }
        
   //    public function DiscountBrand (){
   //          return $this->hasMany('App\Model\DiscountBrand');
   //    }
   //    public function DiscountUserGroup (){
   //          return $this->hasMany('App\Model\DiscountUserGroup');
   //    }
   //    public function DiscountCategory (){
   //          return $this->hasMany('App\Model\DiscountCategory');
   //    }

   //    public function DiscountProduct (){
   //          return $this->hasMany('App\Model\DiscountProduct');
   //    }

  	protected $guarded = [];
}