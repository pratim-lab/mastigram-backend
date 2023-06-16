<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

	const UPDATED_AT = null;

    protected $guarded = [];
}
