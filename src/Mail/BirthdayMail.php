<?php

namespace Bishopm\Bible\Mail;

use Illuminate\Mail\Mailable;

class BirthdayMail extends Mailable
{

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $emaildata;

    public function __construct($emaildata)
    {
        $this->emaildata=$emaildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emaildata['subject'])
            ->from($this->emaildata['sender'])
            ->markdown('bible::emails.birthday');
    }
}
