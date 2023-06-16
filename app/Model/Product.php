<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    protected $guarded = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function scopeActive($query)
    {
        return $query->where('products.status','A');
    }

    public function category(){
    	return $this->belongsTo('App\Model\Category', 'categories_id');
    }
	
	public function sub_category(){
    	return $this->belongsTo('App\Model\Category', 'sub_categories_id');
    }

    public function occasion(){
    	return $this->belongsTo('App\Model\Occasion', 'occasions_id');
    }

    public function assign_extra_addon(){
    	return $this->hasMany('App\Model\AssignProductExtra', 'product_id')->orderBy('id','DESC');
    }
	
	public function productVolumePrice(){
    	return $this->hasMany('App\Model\ProductVolume', 'product_id')->orderBy('id','DESC');
    }
    /* 21.01.2019 (where condition added) */
    public function product_attr(){
    	return $this->hasOne('App\Model\ProductAttribute', 'product_id')->where('is_block','N');
    }
     public function product_attrs(){
        return $this->hasMany('App\Model\ProductAttribute', 'product_id')->where('is_block','N');
    }

    public function product_attribute_without_condition(){
        return $this->hasMany('App\Model\ProductAttribute', 'product_id')->where('is_block','<>','D');
    }
    /* 21.01.2019 (where condition added) */

    public function product_image(){
    	return $this->hasMany('App\Model\ProductImage', 'product_id');
    }

    public function default_product_image(){
    	return $this->hasOne('App\Model\ProductImage', 'product_id')->where('default_image', 'Y');
    }

    public function product_video(){
        return $this->hasOne('App\Model\ProductVideo', 'product_id')->select('iframe_code');
    }

    //Special Delivery section
    public function delivery_option(){
        return $this->belongsTo('App\Model\DeliveryOption', 'special_delivery')->select('title');
    }

    //Product Shipping section
    public function shipping_method(){
        return $this->hasMany('App\Model\ProductShipping', 'product_id')->select('shipping_method_id');
    }

    //Related Products section
    public function related_products(){
        return $this->hasMany('App\Model\RelatedProduct', 'product_id')->select('related_product_id')->where('type','R');
    }
	
	 //Frequently Bought Together section
    public function frequently_bought_together_product_ids(){
        return $this->hasMany('App\Model\RelatedProduct', 'product_id')->select('related_product_id')->where('type','B');
    }

    //Related Products for product details page
    public function related_prod(){
        return $this->hasMany('App\Model\RelatedProduct', 'product_id')->select('related_product_id')->where('type','R')->orderBy('product_id','desc')->take(8);
    }
	
	//Frequently Bought Together details page
    public function frequently_bought_together_product_details(){
		 return $this->hasMany('App\Model\RelatedProduct', 'product_id')->select('related_product_id')->where('type','B')->orderBy('product_id','desc')->take(2);
    }

    //Related Cities section
    public function related_cities(){
        return $this->hasMany('App\Model\RelatedCity', 'product_id')->select('cities_id');
    }

    //Related Cities Group
    public function related_cities_group(){
        return $this->hasMany('App\Model\ProductRelatedCityGroup', 'product_id')->select('city_groups_id');
    }

    public function order_product_attribute(){
        return $this->hasOne('App\Model\ProductAttribute', 'product_id');
    }

    public function order_product_all_attributes(){
        return $this->hasMany('App\Model\ProductAttribute', 'product_id');
    }

    //Related Gift addon group ids
    public function related_gift_addon_group(){
        return $this->hasMany('App\Model\ProductRelatedGiftAddonGroup', 'product_id');
    }

    //Related restricted pincode group ids
    public function related_restricted_pincode_group(){
        return $this->hasMany('App\Model\ProductRelatedRestrictedPincodeGroup', 'product_id');
    }

    //Related Extra addon group ids
    public function related_extra_addon_group(){
        return $this->hasMany('App\Model\AssignProductExtra', 'product_id');
    }
	
	public function discount_detail(){
    	return $this->belongsTo('App\Model\Discount', 'discount_id');
    }

    public function product_metal()
    {
        return $this->belongsTo('App\Model\ProductMetal','product_metal_id');
    }
    
     //Product Specification
    public function product_spec(){
        return $this->hasMany('App\Model\ProductSpecification', 'product_id');
    }


    //Create unique slug
    public static function getUniqueSlug( $title, $id = 0 ) {
        // Normalize the title
        //str_slug($title);
        $slug = Str::slug($title, '-');

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = Product::select('slug')->where('slug', 'like', $slug.'%')
                                ->where('id', '<>', $id)
                                ->get();

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= count($allSlugs); $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
    }
}
