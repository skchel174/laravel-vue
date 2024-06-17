<?php

declare(strict_types=1);

namespace App\Notifications\User;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class VerifyRegistration extends Notification
{
    use Queueable;

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(User $user): MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::get('Verify Registration'))
            ->line(Lang::get('Please click the button below to verify registration.'))
            ->action(Lang::get('Verify'), route('register.verify', [
                'token' => $user->verifyToken->token,
            ]));
    }
}
