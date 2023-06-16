<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class OccasionLink extends Model
{
    protected $table = 'occasion_links';

    public $timestamps = false;

    protected $guarded = [];
}