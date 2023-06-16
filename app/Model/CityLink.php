<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CityLink extends Model
{
    protected $table = 'city_links';

    public $timestamps = false;

    protected $guarded = [];
}