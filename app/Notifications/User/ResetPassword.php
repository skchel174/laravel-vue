<?php

declare(strict_types=1);

namespace App\Notifications\User;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(User $user): MailMessage
    {
        $url = route('password', [
            'user' => $user->id,
            'token' => $user->verify_token->getValue(),
        ]);

        return (new MailMessage())
            ->subject(trans('Reset Password Notification'))
            ->line(trans('You are receiving this email because we received a password reset request for your account.'))
            ->action(trans('Reset Password'), $url);
    }
}
