<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $table = 'specifications';

    protected $guarded = [];
	
	public function specificationOptions(){
    	return $this->hasMany('App\Model\SpecificationOption', 'specification_id')->orderBy('display_order','ASC')->select('id','specification_id','title','slug')->active();
    }

    public function specificationCategory(){
        return $this->hasMany('App\Model\SpecificationCategory', 'specification_id')->join('categories', 'categories.id', '=', 'specification_category.category_id')->join('taxonomies as taxonomy', 'categories.taxonomy_id', '=', 'taxonomy.id')->orderBy('taxonomy.title', 'ASC');
    }

    public function productSpec(){
        return $this->hasOne('App\Model\ProductSpecification','specification_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_block','N');
    }


	//Create unique slug
    public static function getUniqueSlug( $title, $id = 0 ) {
        // Normalize the title
        //$slug = str_slug($title);
			$slug = $title;
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = Specification::select('slug')->where('slug', 'like', $slug.'%')
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
