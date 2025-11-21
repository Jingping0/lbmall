<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReturnReply extends Mailable 
{
    use Queueable, SerializesModels;

    public $return;


    public function __construct($return)
    {
        $this->return = $return;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Return and Refund Notification',
        );
    }


    public function build()
    {
        return $this->view('emails.returnReply')
            ->subject('Refund and Return Message Detail');
           
    }
}

