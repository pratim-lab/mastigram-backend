<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\ProductImage;
use App\Model\ProductAttribute;
use App\Model\Currency;
use App\Model\User;
use App\Model\Order;
use App\Model\Brand;
use App\Model\Setting;
use App\Model\OrderDetail;
use App\Model\UserAddress;
use App\Model\Rating;
use App\Model\AskQuestion;
use App\Model\Category;
use App\Model\ProductSpecification;
use App\Model\TaxClass;
use App\Model\Shipping;
use App\Model\PincodeGroup;
use App\Model\ShippingMethod;
use App\Model\City;
use App\Model\UnitType;

use DB;

class ApiController extends \App\Http\Controllers\Controller
{
	
	protected function getProductImage($productId)
	{
		
	
		$images = [];
		$defaultImg = null;
		$product_image = ProductImage::where('product_id',$productId)->get();
		foreach($product_image as $img){
			$images[] = url('/').'/uploaded/product/' . $img['name'];
			if($img['default_image'] == 'Y'){
				$defaultImg = url('/').'/uploaded/product/' . $img['name'];
			}
		}
		
		return ['image' => $images, 'default_image' => $defaultImg];
	}

	protected function getProductImageDefult($productId)
	{
		if(!$productId) return ['image' => null, 'default_image' => null];
	
		$images = [];
		$defaultImg = null;
		$product_image = ProductImage::where('product_id',$productId)->get();
		foreach($product_image as $img){
			if($img['default_image'] == 'Y'){
				$defaultImg = url('/').'/uploaded/product/' . $img['name'];
			}
		}
		
		return  $defaultImg;
	}
	public function updateCurrecyPrice($amount,$carrencyKey)
	{
		$ca = Currency::where('currency',$carrencyKey)->first();
		if($ca->currency == 'USD'){
			return $amount/$ca->second_value;
		}else{
			return $amount;
		}
	}

	protected function priceUpdatCart($conditions,$currenyCode=null){
		$order_dtl = Order::where($conditions)->first();
		$settings = Setting::first();
		$currency_key = $currenyCode ? $currenyCode : $settings->default_currency;
		//dd($currency_key);
	   	if(!empty($order_dtl)){
	   		$order_details = OrderDetail::where([['order_id','=',$order_dtl->id],['order_status','=','IP'],['is_shipped','=','N'],['is_delivered','=','N']])->get();

		   	// price update cart start 
	        if(!empty($order_details)){
	        	$total_item_price = 0;
	        	$tax_excluded_price = 0;
	        	$total_discount_price = 0;
	        	$total_coupon_price= 0;
	        	$total_gst = 0;
	        	$total_payment_gateway_price = 0;
	        	$total_ship_price = 0;
				$total_weight = 0;

	        	foreach($order_details as $key=>$orderDetail){
	        		
		        	$product_attr = ProductAttribute::where(['id'=>$orderDetail->product_attr_id,'product_id'=>$orderDetail->product_id])->first();
		        	
		        	$unit_tax_excluded_price= $product_attr->tax_excluded_price;
		        	$tax_excluded_price = $unit_tax_excluded_price*$orderDetail->qty;

		        	$payment_geteway_price = 0;
					
		        	$shipping_charges = 0;
					
					if($orderDetail->product->categories_id != '11' && $orderDetail->product_total_weight > 0){
						// insert product weight to the product 
						$total_weight += $orderDetail->product_total_weight;
					}

		        	$unit_price = $product_attr->price;
		        	$total_price = $unit_price*$orderDetail->qty;
					$total_item_price += $total_price;


		        	$orderDetail->update([
		        		'unit_price'=>$this->updateCurrecyPrice($unit_price,$currency_key),
		        		'tax_excluded_price'=>$this->updateCurrecyPrice($tax_excluded_price,$currency_key),
		        		'payment_geteway_price'=>$this->updateCurrecyPrice($payment_geteway_price,$currency_key),
		        		'shipping_charges'=>$this->updateCurrecyPrice($shipping_charges,$currency_key),
		        		'total_price'=>$this->updateCurrecyPrice($total_price,$currency_key)
		        	]);
	        	}
	        }
	        if(!empty($order_dtl)){
				$order_dtl->update([
					'total_item_price'=>$this->updateCurrecyPrice($total_item_price,$currency_key),
					'currency_key' => $currency_key,
					'total_weight' => $total_weight,
				]);
	        }
	    }else{
	    	//dd($conditions);
	    	$order_array = array();
			$order_array['session_id'] = $conditions['session_id'];
			//$order_array['user_id'] = isset($conditions['user_id']) ? $conditions['user_id'] : NUll;
			$order_array['unique_order_id'] = $this->Order_number();;
			$order_array['ip_address'] = $_SERVER["REMOTE_ADDR"];
			$order_array['type'] = 'cart';
			$order_array['currency_key'] = $currency_key;
			$order_array['created_at'] = date('Y-m-d H:i:s');
			//$order_array['currency_key']   = $settings->default_currency;
			//$order = Order::create($order_array);
			//dd($currency_key);
	    }
	}

	protected function priceCalculation($productId)
	{
		$product_attr = ProductAttribute::where('product_id',$productId)->first();
		$price_backup = [];
		$price = array(
			'id' => 0,
			'sku' => 0,
			'minimum_order' => 0,
			'minimum_order_type'=>'',
			'minimum_order_text' => '',
			'stock' => 0,
			'length' => 0,
			'weight' => 0,
			'height' => 0,
			'weight' => 0,
			'price_backup' =>$price_backup,
			
		);
		if($product_attr){
		
		$currencies = Currency::where('is_block','N')->get();
		$unit_type = UnitType::find($product_attr->unit_type_id);
		$setting = Setting::select('id','default_currency')->first();
		$minimum_order_text = '';
		if($unit_type){
			$minimum_order_text = "Minimum order $product_attr->minimum_order $unit_type->title";
		}
		foreach($currencies as $currency){
			 $default = 'N';
			// if($currency->currency == $setting->default_currency){
			// 	$default = 'Y';

			// }
			if($currency->currency == 'USD'){
				$gst_price = 0;
				$orginal_price =  $product_attr->orginal_price/$currency->second_value;
				$price = $product_attr->price/$currency->second_value;
				if($product_attr->gst){
					$gst_price = $price/100*$product_attr->gst;
				}
			}else {
				$gst_price = 0;
				$orginal_price =  $product_attr->orginal_price;
				$price = $product_attr->price;
				if($product_attr->gst){
					$gst_price = $price/100*$product_attr->gst;
				}
				$default = 'Y';
			}

			$price_backup[] = ['orginal_price'=>round($orginal_price,2),'price'=>round($price,2),'gst_price'=>round($gst_price,2),'code'=>$currency->html_code,'currency'=>$currency->currency,'defult'=>$default];
		}

		$price = array(
			'id' => $product_attr->id,
			'sku' => $product_attr->sku,
			'minimum_order' => $product_attr->minimum_order,
			'minimum_order_type'=>$unit_type ? $unit_type->title : '',
			'minimum_order_text' => $minimum_order_text,
			'stock' => $product_attr->stock,
			'length' => $product_attr->length,
			'weight' => $product_attr->weight,
			'height' => $product_attr->height,
			'weight' => $product_attr->weight,
			'price_backup' =>$price_backup,
			
		);
		}
		return $price;
	}
	/**
     * Search
     *
     * @param  [Array] product
     * @param  [String] Images multiple Yes/No
     
     */

	protected function getProductList($product, $multiImage = 'N', $specfication = 'N', $ratings_type = 'N',$questionAnswer = 'N')
	{
		$images = $this->getProductImage($product->id);
		if($multiImage == "Y"){
		$product['images'] = $images['image'];
		}
		$product['default_image'] = $images['default_image'];
		if($specfication == "Y"){
			$all_specifications = ProductSpecification::select('specifications.title as s_title','specification_options.title as so_title')->join('specifications','product_specifications.specification_id','=','specifications.id')->join('specification_options','product_specifications.specification_option_id','=','specification_options.id')->where('product_id',$product->id)->get();
			$product['specifications'] = $all_specifications;
		}
		// dd($all_specifications)
		/*** Brand section  ****/
		$brand = [];
		if(!empty($product->brand)){
			$brandObj = Brand::find($product->brand);
			if($brandObj){
				$brand = array(
					'id' => $brandObj->id,
					'title' => $brandObj->title,
					//'image' => $brandObj->image ? url('/').'/uploaded/brand/'.$brandObj->image : null
				);
				
			}
		}
		$product['brand'] = $brand;
		/*** Brand section end  ****/

		if($product->categories_id){
			$category = Category::join('taxonomies','categories.taxonomy_id','=','taxonomies.id')->find($product->categories_id);
			//dd($category);
			
			$product['cat_slug'] = $category->slug;
		}
		/*** Brand section end  ****/

		//manage average ratings
		$rating = DB::table('ratings')
					->where('product_id', $product->id)
					->where('status', 1)
					->avg('rating');
		$product['avarage_rating'] = ($rating > 0) ? number_format((float)$rating, 2, '.', '') : 0;
		
		//total ratings
		$total_rating = DB::table('ratings')
					->where('product_id', $product->id)
					->where('status', 1)
					->count();
		$product['total_rating'] = $total_rating;
		$product['attribute'] = $this->priceCalculation($product->id);
		if($ratings_type == 'Y'){
			$ratings = DB::table('ratings')->select('ratings.rating','ratings.comment','ratings.created_at','ratings.title','users.name')->where('product_id',$product->id)->leftJoin('users', 'users.id', '=', 'ratings.user_id')->get();
			$product['ratings'] = $ratings;
		}
		if($questionAnswer == 'Y'){
			$qnsAns = AskQuestion::with('answers')->active()->select('ask_questions.id','ask_questions.comment','ask_questions.created_at','ask_questions.replay_id','users.name')->whereNull('replay_id')->where('product_id',$product->id)->leftJoin('users', 'users.id', '=', 'ask_questions.user_id')->get();
			$product['qnsAns'] = $qnsAns;
			//dd($qnsAns);
		}
		return $product;
	}


	//Generating order details as an organised array
    public function getCartItemDetails($session_id = null, $currenyCode = NUll) {
		if(!empty($session_id)){
			$sessionId = $session_id;
		}
		$user_id = 0;
		if(Auth::guard('api')->check()){
			$user_id = Auth::guard('api')->user()->id;
			$conditions = ['user_id'=>$user_id,'type'=>'cart'];
			
		}else{
			$conditions = ['session_id'=>$sessionId,'type'=>'cart'];
		}
		$order_dtl = Order::where($conditions)->first();
		if(!$order_dtl){
			if($currenyCode == null){
				$currency = Currency::where(['currency'=>'NGN'])->first();
			}else{
				$currency = Currency::where(['currency'=>$currenyCode])->first();
			}
			
	       	$currency_key = $currency->currency; 
			$currency_code = $currency->html_code; 
			$item_dtl = array(); 
			$cart_detail_array = array(
					'order_id'=>0,
					'total_payment_price'=>0, 
					'delivery_email'=>0,
					'unique_order_id'=>0,
					'existing_order_session_id'=>0, 
					'item_dtl'=>$item_dtl, 
					'total_item'=>0,
					'total_tax_excluded_price' => 0,
					'total_tax_amount'=>0, 
					'shipping_price' => 0,
					'total_payment_gateway_price' => 0,
					'total_cart_price'=>0,
					'currency_key'=>$currency_key,
					'currency_code'=>$currency_code,
					'active_address' => '',
					'applied_coupon_details' => 0,
					'total_discount_price' => 0,
					'wallet_used_amount' => 0,
					'wallet_used_point' => 0,
					'digital_wallet_used_gm' => 0,
					'digital_wallet_used_amount' => 0,
					'shipping_tariff_calculation_msg' => '',
		
				);
					
					
			return $cart_detail_array;
		}
		/**** Price Upade section start   ******/

		$this->priceUpdatCart($conditions,$currenyCode);
		/**** Price Upade section end  *****/

       	

       	$shipping_price = 0.00;
        $currency_key = $order_dtl ? $order_dtl->currency_key: '';
        $currency_code = '';
        $total_cart_price = 0.00;
        $total_tax_excluded_price = 0.00;
        $total_payment_gateway_price = 0.00;
        $total_discount_price = 0.00;
        $wallet_amount = 0.00;
        $total_tax_amount = 0.00;
        $wallet_used_point = 0;
        $digital_wallet_used_gm = 0.00;
        $digital_wallet_used_amount = 0.00;
        $cart_array = array(); 
        $activeAddress = [];
        $total_payment_price = 0;
        $applied_coupon_details = [];

         if(!empty($order_dtl)){
		   	$order_details = OrderDetail::where([['order_id','=',$order_dtl->id],['order_status','=','IP'],['is_shipped','=','N'],['is_delivered','=','N']])->get();
	        
	        $currency = Currency::where(['currency'=>$order_dtl->currency_key])->first();
	       	$currency_code = $currency->html_code;

	        if(!empty($order_details)){
	        	foreach($order_details as $key=>$orderDetail){
	        		$product_attr = ProductAttribute::where(['id'=>$orderDetail->product_attr_id,'product_id'=>$orderDetail->product_id])->first();
	        		$newProduct['product_name'] = $orderDetail->product->product_name;
	        		$newProduct['slug'] = $orderDetail->product->slug;
	        		$newProduct['default_image'] = $this->getProductImageDefult($orderDetail->product_id);
	        		$newProduct['order_details_id'] = $orderDetail->id;
	        		$newProduct['stock'] = $product_attr->stock;
	        		$newProduct['qty'] = $orderDetail->qty;
	        		$newProduct['price'] = $orderDetail->total_price;
	        		$newProduct['minimum_order'] = $product_attr->minimum_order;
	        		$cart_array[$key] = $newProduct;
	 				
	        	}

	        }
			

	        // address section add 
			$activeAddressId = $order_dtl->delivery_address_id;
			if($activeAddressId){
				$userAddress = UserAddress::where(['id' => $activeAddressId])->first();
				if($userAddress){
					$activeAddress = array(
						'id' => $userAddress->id,
						'name' => $userAddress->name,
						'city' => $userAddress->city,
						'state' => $userAddress->state,
						'pincode' => $userAddress->pincode,
						'country' => $userAddress->country,
						'address' => $userAddress->address,
						'mobile' => $userAddress->mobile,
						'email' => $userAddress->email,
						'address_mode' => $userAddress->address_mode
					);
				}
			}

			$total_cart_price = $order_dtl->total_item_price;
	        $total_cart_count_item = count($cart_array);
	    }
		$total_tax_excluded_price = $total_cart_price;
		// Add total_tax_amount
		$TaxClass = TaxClass::first();
		$total_tax_amount = ($total_cart_price*$TaxClass->amount/100);
		//$total_tax_amount = round($total_tax_amount,2);
	    $total_cart_price =$total_cart_price+$total_tax_amount;
		
		/// Add Total shiping amount and update the total amount on order table
		if(isset($order_dtl->delivery_city) && $order_dtl->delivery_city!=null && $order_dtl->delivery_state!=null  && $order_dtl->total_weight > 0  ){
			// shipping price to be calculate  Shipping
			$city_detail = City::where([['name','LIKE','%'.$order_dtl->delivery_city.'%']])->first();
			
			if($city_detail){
				// find the shippings
				$shipping_detail = Shipping::where([
							['shipping_zone','=',$city_detail->pincode_group_id],
							['weight','=',$order_dtl->total_weight]
							])->first();
				
				if($shipping_detail){
					$shipping_price = $this->updateCurrecyPrice($shipping_detail->price,$currency_key);
					//$shipping_price = $shipping_detail->price;
				} 
				
			}
		}
		$total_cart_price =$total_cart_price+$shipping_price;
		$total_cart_price = round($total_cart_price,2);
		
	    if($currency_key == 'USD'){
	    	$currency = Currency::where(['currency'=>'USD'])->first();
	    	$total_payment_prices = $total_cart_price*$currency->second_value;
	    	$total_payment_price = $total_payment_prices*100;
			//$total_payment_price = round($total_payment_price,2);
	    }else{

	    	$total_payment_price =$total_cart_price*100;
			
	    }
		// show message for the category which has no shipping_tariff_calculation
		$category_detail = $order_dtl->order_category;
		if($order_dtl->order_category->shipping_tariff_calculation == 'N'){
			$settings = Setting::first();
			$shipping_tariff_calculation_msg = $settings->shipping_tariff_calculation_msg;
		}else{
			$shipping_tariff_calculation_msg = '';
		}
				

		$cart_detail_array = array(
		
		'order_id'=>$order_dtl['id'],
		'total_payment_price'=>$total_payment_price, 
		'delivery_email'=>$order_dtl['delivery_email'],
		'unique_order_id'=>$order_dtl['unique_order_id'],
		'existing_order_session_id'=>$order_dtl['session_id'], 
		'item_dtl'=>$cart_array, 
		'total_item'=>$total_cart_count_item,
		'total_tax_excluded_price' => round($total_tax_excluded_price,2),
		'total_tax_amount'=>round($total_tax_amount,2), 
		'shipping_price' => $shipping_price,
		'total_payment_gateway_price' => $total_payment_gateway_price,
		'total_cart_price'=>$total_cart_price,  //round($total_cart_price,2),
		'currency_key'=>$currency_key,
		'currency_code'=>$currency_code,
		'active_address' => $activeAddress,
		'applied_coupon_details' => $applied_coupon_details,
		'total_discount_price' => $total_discount_price,
		'wallet_used_amount' => $wallet_amount,
		'wallet_used_point' => $wallet_used_point,
		'digital_wallet_used_gm' => $digital_wallet_used_gm,
		'digital_wallet_used_amount' => $digital_wallet_used_amount,
		'shipping_tariff_calculation_msg' => $shipping_tariff_calculation_msg,
		
		);
        // update the order table for new updates 
		$order_dtl->total_tax_excluded_price = round($total_tax_excluded_price,2);
		$order_dtl->total_gst = round($total_tax_amount,2);
		$order_dtl->total_ship_price = $shipping_price;
		$order_dtl->total_payment_gateway_price = $total_payment_gateway_price;
		$order_dtl->amount = $total_cart_price;
		$order_dtl->save();
		
		
        return $cart_detail_array;
    }
	protected function sendSuccess($data=[],$token =null,$message=null)
    {
        $response = [
            'status' => true,
            'token'=>$token,
            'message' => $message,
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        return response()->json($response,200);
    }

    protected function sendErrors($error, $errorMessages = [])
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['error'] = $errorMessages;
        }

        return response()->json($response,200);
    }
	
	
}