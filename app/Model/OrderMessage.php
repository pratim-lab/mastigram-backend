<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderMessage extends Model
{
    protected $table = 'order_messages';

    protected $guarded = [];

    public function order_message_type() {
        return $this->belongsTo('App\Model\MessageType','message_type_id');
    }

}