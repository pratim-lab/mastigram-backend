<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailOnRequest extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        
        $this->data=$params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from(config('global.admin_email_id'))
                    ->subject(config('global.website_title_camel_case').' — '.$this->data['subject'])
                    ->markdown('site.emails.order.sendMailOnRequest')->with(['data'=>$this->data]);
    }
}
