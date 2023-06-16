<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $table = 'product_specifications';

    protected $guarded = [];
	
	public function specificationOptions(){
    	return $this->hasMany('App\Model\SpecificationOption', 'specification_id')->orderBy('id','DESC')->select('id','specification_id','title','slug')->active();
    }

    public function scopeActive($query)
    {
        return $query->where('is_block','N');
    }


	
}
