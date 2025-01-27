<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderFailedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order
    ){}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Failed: Action Required',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order-failed-mail',
        );
    }
    
    public function attachments(): array
    {
        return [];
    }
}
