<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterVerification extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $url = route('register.verify', [
            'token' => $notifiable->verify_token->getValue()
        ]);

        return (new MailMessage)
            ->subject(sprintf('Welcome to %s!', config('app.name')))
            ->greeting(sprintf('Hello %s!', $notifiable->username))
            ->line('To get started, please verify your email address by clicking the button below:')
            ->action('Verify Email Address', $url)
            ->line('If you did not create an account, no further action is required.')
            ->salutation('Best regards,')
            ->salutation(sprintf('The %s Team', config('app.name')));
    }
}
