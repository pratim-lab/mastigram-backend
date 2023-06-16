<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_token = rand(111111,999999);
		/* base64_encode(rand(999999,9999999).$this->user->email.rand(999999,9999999)); */
        $this->user->email_token = $email_token;
		$this->user->otp = $email_token;
        $this->user->save();
		
		return $this->from(config('global.admin_email_id'))
                    ->subject(config('global.website_title_camel_case').'—'.'Reset Password')
                    ->markdown('site.emails.user.passwordreset')->with(['email_token' => $this->user->email_token,'name'=>$this->user->name
            ]);
		
		
       /*  return $this->view('site.emails.user.passwordreset')->subject(config('global.website_title_camel_case').'—'.'Reset Password')->with([
            'email_token' => $this->user->email_token,'name'=>$this->user->name
            ]); */
    }
}
