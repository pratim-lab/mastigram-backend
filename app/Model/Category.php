<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //use SoftDeletes;
    protected $table = 'categories';

    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }

	// loads only direct children - 1 level
	public function children()
	{
	   return $this->hasMany('App\Model\Category', 'parent_id');
	}

	// recursive, loads all descendants
	public function childrenRecursive($id = [])
	{
	   return $this->children()->with('childrenRecursive', 'taxonomy')->whereNotIn('categories.id', $id);
	   // which is equivalent to:
	   // return $this->hasMany('Survey', 'parent')->with('childrenRecursive');
	}

	// parent
	public function parent()
	{
	   return $this->belongsTo('App\Model\Category','parent_id');
	}

	// all ascendants
	public function parentRecursive()
	{
	   return $this->parent()->with('parentRecursive');
	}

	public function category_links(){
    	return $this->hasMany('App\Model\CategoryLink', 'category_id');
    }

    public function products()
  	{
  	   return $this->hasMany('App\Model\Product', 'categories_id');
  	}

}
