<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceipt extends Mailable 
{
    use Queueable, SerializesModels;

    public $order,$payment,$orderDetail;


    public function __construct($order, $payment, $orderDetail)
    {
        $this->order = $order;
        $this->payment = $payment;
        $this->orderDetail = $orderDetail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Notification',
        );
    }


    public function build()
    {
        return $this->view('emails.orderReceipt')
            ->subject('Order Invoice');
           
    }
}

