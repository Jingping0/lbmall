<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactReply extends Mailable 
{
    use Queueable, SerializesModels;

    public $customerService;


    public function __construct($customerService)
    {
        $this->customerService = $customerService;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Customer Service Notification',
        );
    }


    public function build()
    {
        return $this->view('emails.contactReply')
            ->subject('Customer Service Reply');
           
    }
}

