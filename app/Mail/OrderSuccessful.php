<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSuccessful extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order
    ){}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order Has Been Successfully Placed!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order-successful',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
