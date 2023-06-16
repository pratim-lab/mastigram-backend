<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';

    protected $guarded = [];
	
	 public function attributeOptions(){
    	return $this->hasMany('App\Model\ProductAttributeOption', 'product_attribute_id')->orderBy('id','DESC');
    }
	//Create unique slug
    public static function getUniqueSlug( $title, $id = 0 ) {
        // Normalize the title
        //$slug = str_slug($title);
			$slug = $title;
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = ProductAttribute::select('attr_slug')->where('attr_slug', 'like', $slug.'%')
                                ->where('id', '<>', $id)
                                ->get();

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('attr_slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= count($allSlugs); $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('attr_slug', $newSlug)) {
                return $newSlug;
            }
        }
    }
}
