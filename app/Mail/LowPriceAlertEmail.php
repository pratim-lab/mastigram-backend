<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LowPriceAlertEmail extends Mailable
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
        /* $this->user=$params['user']; */
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
                    ->subject(config('global.website_title_camel_case').'— Low Price Alert')
                    ->markdown('site.emails.user.lowpricealertemail')->with(['data'=>$this->data]);
    }
}
