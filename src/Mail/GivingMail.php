<?php

namespace Bishopm\Bible\Mail;

use Illuminate\Mail\Mailable;

class GivingMail extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['subject'])
            ->from($this->data['sender'])
            ->markdown('bible::emails.givingreport');
    }
}
