<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class FalseurlLink extends Model
{
    protected $table = 'falseurl_links';

    public $timestamps = false;

    protected $guarded = [];
}