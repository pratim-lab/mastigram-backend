<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $guarded = [];

    public function ContactConversation()
	{
	   return $this->hasMany('App\Model\ContactConversation', 'contact_id');
	}
}