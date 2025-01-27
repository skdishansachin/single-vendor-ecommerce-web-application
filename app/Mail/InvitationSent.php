<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationSent extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Invitation $invitation,
        public string $signedUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your invited by Groke.',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.invitation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
