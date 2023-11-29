<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private readonly User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration verification',
        );
    }

    public function content(): Content
    {
        $url = route('register.verify', [
            'token' => $this->user->verify_token->getValue()
        ]);

        return new Content(
            markdown: 'emails.verify',
            with: [
                'url' => $url,
            ],
        );
    }
}
