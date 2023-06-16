<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';

    protected $guarded = [];
    
    public function newsletter_group(){
    	return $this->belongsTo('App\Model\NewsletterGroup', 'group_id');
    }
}
