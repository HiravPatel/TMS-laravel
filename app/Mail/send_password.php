<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class send_password extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $password;
    public $role;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password, $role)
    {
        $this->user = $user;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
                return $this->subject('Your Details')
                    ->view('email_details');

    }
}
