<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class OrderFulfilledMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order
    ){}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order #'.Str::take(Str::reverse($this->order->id), 5).' Has Been Fulfilled!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order-fulfilled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
