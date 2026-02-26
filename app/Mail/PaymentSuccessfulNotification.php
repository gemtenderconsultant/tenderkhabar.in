<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfulNotification extends Mailable
{
    use Queueable, SerializesModels;

    // This variable will hold the data we send from the controller
    public $details;

    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Payment Received - TenderKhabar')
                    ->view('emails.payment_success'); 
                    // This points to resources/views/emails/payment_success.blade.php
    }
}