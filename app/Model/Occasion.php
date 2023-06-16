<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    protected $table = 'occasions';

    protected $guarded = [];

    public function taxonomy(){
    	return $this->belongsTo('App\Model\Taxonomy');
    }

    public function occasion_links(){
    	return $this->hasMany('App\Model\OccasionLink', 'occasion_id');
    }
}
