<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     * @return void
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
   public function build()
    {
        
        return $this->view('email.contact_us')  // Blade view name
                    ->with('contactData', $this->contactData)
                    ->subject('New Contact Message');
    }
}
