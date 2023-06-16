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




    //=========Geting search result=======//
    public static function get_search_content(){
        $categories = Category::select(['taxonomy.title','taxonomy.slug'])
                        ->where([['categories.is_block','N']])
                        ->join('taxonomies as taxonomy', 'categories.taxonomy_id', '=', 'taxonomy.id')
                        ->leftJoin('categories as parent_categories', 'categories.parent_id', '=', 'parent_categories.id')
                        ->leftJoin('taxonomies as parent_taxonomy', 'parent_categories.taxonomy_id', '=', 'parent_taxonomy.id')
                        ->get();
        $occasions = Occasion::select(['taxonomy.title','taxonomy.slug'])
                        ->where([['occasions.is_block','N']])
                        ->join('taxonomies as taxonomy', 'occasions.taxonomy_id', '=', 'taxonomy.id')
                        ->get();
        $return_combination_result = array_merge($categories->toArray(),$occasions->toArray());
        shuffle($return_combination_result);
        $return_combination_result_array = array();
        if(count($return_combination_result)>0){
            foreach ($return_combination_result as $key => $content) {
                $return_combination_result_array[$key]['value'] = $content['title'];
                $return_combination_result_array[$key]['url'] = url("/{$content['slug']}");
            }
        }
        return $json_data = json_encode($return_combination_result_array);
        // return str_replace("'", "", $json_data);
    }
    //Getting home page currency
    public static function get_currency() {
        $home_currency = Currency::where('is_block','=','N')->orderBy('id','DESC')->get();
        return $home_currency;
    }

    //Get Current Date Time
    public static function get_current_date_time() {
        $ip = '103.251.83.170';
        //$ip = '110.142.215.61';
        //$ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

        if( isset($query) && $query['status'] == 'success' ) {
            date_default_timezone_set($query['timezone']);
            return date('M d, Y H:i:s');
        }else{
            date_default_timezone_set('Asia/Kolkata');
            return date('M d, Y H:i:s');
        }
    }

    //Getting IP wise details and current date time
    public static function get_date_time(){
        $ip = '103.251.83.170';
        //$ip = '110.142.215.61';
        //$ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

        if( isset($query) && $query['status'] == 'success' ) {
            date_default_timezone_set($query['timezone']);
            return date('M d, Y 17:30:00');
        }else{
            date_default_timezone_set('Asia/Kolkata');
            return date('M d, Y 17:30:00');
        }
    }

    //Getting IP wise details and current time
    public static function get_time(){
        $ip = '103.251.83.170';
        //$ip = '110.142.215.61';
        //$ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

        if( isset($query) && $query['status'] == 'success' ) {
            date_default_timezone_set($query['timezone']);
            return date('H:i');
        }else{
            date_default_timezone_set('Asia/Kolkata');
            return date('H:i');
        }
    }

    //Getting Cart Header Count
    
   
    public static function get_setting_data() {
        $setting_data = Setting::first();
        return $setting_data;
    }

   

}
