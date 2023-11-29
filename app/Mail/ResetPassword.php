<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private readonly User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset password',
        );
    }

    public function content(): Content
    {
        $url = route('password.reset.form', [
            'token' => $this->user->verify_token->getValue(),
        ]);

        return new Content(
            markdown: 'emails.reset',
            with: [
                'url' => $url,
            ],
        );
    }
}
