<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailLowPrice extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $product_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$product_data)
    {
        $this->user = $user;
        $this->product_data = $product_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('global.admin_email_id'))
                    ->subject(config('global.website_title_camel_case').'—'.'Price low')
                    ->markdown('site.emails.user.lowpriceemail')->with(['user'=>$this->user,'product_data'=>$this->product_data]);
    }
}