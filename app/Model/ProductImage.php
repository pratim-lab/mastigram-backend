<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $guarded = [];

    //protected $fillable = ['default_image'];

    public function scopeCompanyId($query,$id)
    {
        return $query->where('company_id',$id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_block','N');
    }

}
