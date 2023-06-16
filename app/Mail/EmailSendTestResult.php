<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSendTestResult extends Mailable
{
    use Queueable, SerializesModels;
	protected $message;
    protected $file_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message,$file_name)
    {
        $this->message = $message;
        $this->file_name = $file_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('global.website_title_camel_case').' '.$this->message['subject'])
                    ->markdown('site.emails.user.email_send_test_result')
					->attach(public_path($this->file_name))
					->with(['data'=>$this->message]);
    }
}
