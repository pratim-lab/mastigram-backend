<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    protected $table = 'attribute_options';

    protected $guarded = [];
	
	//Create unique slug
    public static function getUniqueSlug( $title, $id = 0 ) {
        // Normalize the title
		$slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
			
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = AttributeOption::select('slug')->where('slug', 'like', $slug.'%')
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
