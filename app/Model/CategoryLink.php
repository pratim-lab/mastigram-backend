<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryLink extends Model
{
    protected $table = 'category_links';

    public $timestamps = false;

    protected $guarded = [];
}