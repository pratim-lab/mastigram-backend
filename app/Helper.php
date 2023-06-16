<?php
namespace App\Http;
use Auth;
use DB;
use App\Model\Country;
use App\Model\Product;
use App\Model\HomeAds;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Menu;
use App\Model\SideMenu;
use App\Model\AppliedCoupon;
use App\Model\Coupon;
use App\Model\CouponUser;
use App\Model\ProductExtra;
use App\Model\ProductAttribute;
use App\Model\GiftAddon;
use App\Model\User;
use App\Model\City;
use App\Model\Currency;
use App\Model\Occasion;
use App\Model\Category;
use App\Model\Setting;
use App\Model\Wishlist;
use App\Model\OrderAssignAgent;
use DateTime;

use Session;

class Helper{
// this function is used to obtain the country list
    public static function getCountries(){

        $country=Country::where('is_block','N')->get();

        return $country;
    }

    
}
