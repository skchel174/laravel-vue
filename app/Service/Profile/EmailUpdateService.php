<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\Events\User\EmailChanged;
use App\Mail\VerifyEmail;
use App\Models\User\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;

class EmailUpdateService
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly Dispatcher $dispatcher,
    ) {
    }

    public function changeEmail(User $user, string $newEmail): void
    {
        $user->changeEmail($newEmail);

        $this->mailer
            ->to($newEmail)
            ->send(new VerifyEmail($user));
    }

    public function verifyEmail(User $user, string $token): void
    {
        $user->verifyNewEmail($token);

        $this->dispatcher->dispatch(new EmailChanged($user));
    }
}
