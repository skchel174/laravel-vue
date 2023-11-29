<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Events\User\Verified;
use App\Mail\VerifyRegistration;
use App\Models\User\Exceptions\VerificationNotRequested;
use App\Models\User\Password;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;

class RegisterService
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly Dispatcher $eventDispatcher,
        private readonly StatefulGuard $auth,
    ) {
    }

    public function register(string $name, string $email, string $password): User
    {
        $user = User::register($name, $email, Password::create($password));

        $this->sendVerificationEmail($user);

        $this->eventDispatcher->dispatch(new Registered($user));

        $this->auth->login($user);

        return $user;
    }

    public function sendVerificationEmail(User $user): void
    {
        if ($user->verify_token === null) {
            throw new VerificationNotRequested();
        }

        $this->mailer
            ->to($user->email)
            ->send(new VerifyRegistration($user));
    }

    public function verifyRegistration(User $user, string $token): void
    {
        $user->verifyRegistration($token);

        $this->eventDispatcher->dispatch(new Verified($user));
    }
}
