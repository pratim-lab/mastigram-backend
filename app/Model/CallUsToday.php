<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CallUsToday extends Model
{
    protected $table = 'call_us_today';

    protected $guarded = [];

    public function ContactConversation()
	{
	   return $this->hasMany('App\Model\ContactConversation', 'contact_id');
	}
}