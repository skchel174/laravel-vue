<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Events\User\PasswordReset;
use App\Mail\ResetPassword;
use App\Models\User\Password;
use App\Models\User\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Session\Session;

class ResetPasswordService
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly Dispatcher $dispatcher,
        private readonly Session $session,
    ) {
    }

    public function sendVerificationEmail(string $email): void
    {
        /** @var User $user */
        $user = User::whereEmail($email)->firstOrFail();

        $user->requestVerification();

        $this->mailer
            ->to($email)
            ->send(new ResetPassword($user));
    }

    public function changePassword(string $password, string $token): void
    {
        /** @var User $user */
        $user = User::whereVerifyToken($token)->firstOrFail();

        $password = Password::create($password);

        $user->resetPassword($password);

        $this->session->invalidate();

        $this->dispatcher->dispatch(new PasswordReset($user));
    }
}
