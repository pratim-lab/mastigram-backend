<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Banner;
use App\Model\Product;
use App\Model\HomeAds;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\Setting;
use App\Model\Category;
use App\Model\NewsletterGroup;
use App\Model\NewsletterGroupUser;
use App\Model\Rating;
use Validator;
use DB;

class DefaultController extends ApiController
{
	
	
	/**
     * Get Home Page Content
     *
     */
	public function homePage(){
		

		/***  Stratic DATA ***/
		$productWhere = ['is_deleted' => 'N', 'status' => 'A'];
		$limit = 6;

		
		/*** banner data  ***/
		$banners = [];
		$query = Banner::where('is_block', 'N')->get();
		foreach($query as $item){
			$item['image'] = url('/').'/uploaded/banner/'.$item['image'];
			$banners[] = $item;
		}
		
		/*** Home Add data  ***/
		$ads = [];
		$query = HomeAds::where('is_block', 'N')->get();
		foreach($query as $item){
			$item['image'] = url('/').'/uploaded/home_ads/'.$item['image'];
			$ads[] = $item;
		}
		$bestSellers = [];
		
		$proBestSeller = Product::active()->take($limit)->get();

		foreach($proBestSeller as $bestSeller){
			$bestSellers[] = $this->getProductList($bestSeller);
		}

		$ratingTop = [];
		
		$rating = Rating::orderBy('created_at','DESC')->take($limit)->get();

		foreach($rating as $rate){
			$ratingTop[] = $this->getProductList($rate);
		}


		$newProducts = [];
		
		$productsNew = Product::orderBy('created_at','DESC')->active()->take($limit)->get();
		
		foreach($productsNew as $productNew){
			$newProducts[] = $this->getProductList($productNew);
		}
		$categoriesData = [];
		$categories = Category::select('categories.id','taxonomies.title','categories.taxonomy_id')->join('taxonomies', 'categories.taxonomy_id', '=', 'taxonomies.id')->where(['categories.is_block'=>'N','categories.parent_id'=>NULL])->get();
		foreach($categories as $category){
			$products = Product::orderBy('created_at','DESC')->active()->where('categories_id',$category->id)->take($limit)->get();
			$productDAta = [];
			foreach($products as $product){
				$productDAta[] = $this->getProductList($product);
			}
			$categoriesData[] = ['category_name'=>$category->title,'product'=>$productDAta];
		}



		$data = array(
			 'banners' => $banners,
			 'ads' => $ads,
			 'bestSellers'=>$bestSellers,
			 'newProducts'=>$newProducts,
			 'categories'=> $categoriesData,
			 'rating' => $ratingTop,
				dd($ratingTop)
		);
		
		return $this->sendSuccess($data,'','Fetch all products');
		
	}
	
	

	/*
	* Get Countries
	*
	*/
	public function getCountries(){
		$countries = Country::where('is_block', 'N')->get();
		
		return $this->sendSuccess($countries,'','Country data');
	}

	/*
	* Get States
	*
	*/
	public function getStates(Request $request){
		
		dd($request->all());

		if($request->country_id){
			$states = State::where(['is_block' => 'N', 'country_id' =>$request->country_id])->get();
			return $this->sendSuccess($states,'','State data');
		}
		return $this->sendErrors('Something went wrong! Please try again later');
	}
	
	/*
	* Get Cities
	*
	*@param  [int] state_id
	*/
	public function getCities(Request $request){
		$validator = Validator::make($request->all(), [
			'state_id' => 'required'
		]);
		
		if ($validator->fails()){
			return $this->sendErrors('Something went wrong! Please try again later');
		}
		
		$cities = City::where(['is_block' => 'N','state_id' => $request->state_id])->get();
		return $this->sendSuccess($cities,'','City data');
	}

	/**
	 * add user to newsletter
	 * @param  [string] user_email
	 */
	public function addtoNewsletterGroup(Request $request){
		$user_email = $request->user_email;
		if($user_email == ''){
			return $this->sendErrors('Email Id is required.');
		}
		
		$getgroup = NewsletterGroup::first();
		if($getgroup){
			if(NewsletterGroupUser::where('user_email','LIKE',$user_email)->where('group_id',$getgroup->id)->count() > 0){
				return $this->sendErrors('You are already subscribed to our newsletter');
			}else{
				$ins_user = NewsletterGroupUser::create(['group_id'=>$getgroup->id,'user_email'=>$user_email,'created_at' => date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s')]);
				if($ins_user){
					return $this->sendSuccess([],'','Successfully subscribe our newsletter.');
				}else{
					return $this->sendErrors('Cound not add due to some error!');
				}
			}
		}else{
			return $this->sendErrors('Cound not add due to some error!');
		}
		
		

	}
	public function siteData($value='')
	{
		$countries = Country::whereIsBlock('N')->get();
		$setting = Setting::select('*')->first();
		$categories = Category::select('categories.id','taxonomies.title','taxonomies.slug','categories.taxonomy_id','categories.meta_title','categories.meta_keyword','categories.meta_description')->join('taxonomies', 'categories.taxonomy_id', '=', 'taxonomies.id')->where(['categories.is_block'=>'N','categories.parent_id'=>NULL])->get();
		
		
		$data = [
			'countries'=>$countries,
			'setting'=>$setting,
			'categories'=>$categories,
		];
		return $this->sendSuccess($data,'','site data');
	}
	
	
}