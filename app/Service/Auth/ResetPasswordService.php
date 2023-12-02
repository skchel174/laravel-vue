<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Events\User\PasswordReset;
use App\Mail\ResetPassword;
use App\Models\User\Password;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Session\Session;

class ResetPasswordService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly Mailer $mailer,
        private readonly Dispatcher $dispatcher,
        private readonly Session $session,
    ) {
    }

    public function sendVerificationEmail(string $email): void
    {
        $user = $this->repository->getByEmail($email);

        $user->requestVerification();

        $this->mailer
            ->to($email)
            ->send(new ResetPassword($user));
    }

    public function changePassword(string $password, string $token): void
    {
        $user = $this->repository->getByVerifyToken($token);

        $password = Password::create($password);

        $user->resetPassword($password);

        $this->session->invalidate();

        $this->dispatcher->dispatch(new PasswordReset($user));
    }
}
