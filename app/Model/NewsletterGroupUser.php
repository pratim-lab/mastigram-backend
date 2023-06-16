<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewsletterGroupUser extends Model
{
    protected $table = 'newsletter_group_users';

    protected $guarded = [];

    public function user_data(){
    	return $this->belongsTo('App\Model\User', 'user_id')->select('id','name');
    }
}
