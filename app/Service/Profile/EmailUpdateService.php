<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\Events\User\EmailChanged;
use App\Mail\VerifyEmail;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;

class EmailUpdateService
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly Dispatcher $dispatcher,
        private readonly StatefulGuard $auth,
    ) {
    }

    public function changeEmail(string $newEmail): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        $user->changeEmail($newEmail);

        $this->mailer
            ->to($newEmail)
            ->send(new VerifyEmail($user));
    }

    public function verifyEmail(string $token): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        $user->verifyNewEmail($token);

        $this->dispatcher->dispatch(new EmailChanged($user));
    }
}
