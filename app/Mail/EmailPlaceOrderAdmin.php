<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailPlaceOrderAdmin extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $order_data;
    protected $main_order_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   public function __construct($user,$order_data,$main_order_data)
    {
        $this->user = $user;
        $this->order_data = $order_data;
        $this->main_order_data = $main_order_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        /* return $this->from(config('global.admin_email_id'))
                    ->subject(config('global.website_title_camel_case').'—'.'You have received a new order!')
                    ->markdown('site.emails.order.place_order_admin')->with(['data'=>$this->user]); */
					
		return $this->from(config('global.admin_email_id'))
                    ->subject(config('global.website_title_camel_case').'—'.'A new order "'.$this->main_order_data->unique_order_id.'" has been placed successfully!')
                    ->markdown('site.emails.order.place_order_admin')->with(['data'=>$this->user,'order_data'=>$this->order_data,'main_order_data'=>$this->main_order_data]);
    }
}