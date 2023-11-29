<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Events\User\PasswordReset;
use App\Mail\ResetPassword;
use App\Models\User\Password;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;

class ResetPasswordService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly Mailer $mailer,
        private readonly Dispatcher $dispatcher,
        private readonly SessionGuard $sessionGuard,
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

    /**
     * @throws AuthenticationException
     */
    public function changePassword(string $password, string $token): void
    {
        $user = $this->repository->getByVerifyToken($token);

        $user->resetPassword(Password::create($password));

        $this->dispatcher->dispatch(new PasswordReset($user));

        $this->sessionGuard->logoutOtherDevices($password);
    }
}
