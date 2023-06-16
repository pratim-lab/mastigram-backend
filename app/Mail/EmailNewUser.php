<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNewUser extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from(config('global.admin_email_id'))
                    ->subject(config('global.website_title_camel_case').'—'.'Account Information')
                    ->markdown('site.emails.user.new_user')->with(['data'=>$this->user, 'password' => $this->password]);
    }
}
