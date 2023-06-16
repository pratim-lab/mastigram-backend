<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    protected $table = 'restrictions';

    protected $guarded = [];

    public function City()
    {
        return $this->belongsTo('App\Model\City')->select(['id', 'name']);
    }
}