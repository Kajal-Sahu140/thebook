<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class forgetPasswordAdmin extends Mailable
{
    use Queueable, SerializesModels;
   
    public $otpValue;
    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($otpValue)
    {
        $this->otpValue = $otpValue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {
        return $this->subject('Your OTP Code')
                    ->view('email.forgotpassword')
                    ->with('otpValue', $this->otpValue);
    }
}