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
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Arr;

class RegisterService
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly Dispatcher $eventDispatcher,
        private readonly StatefulGuard $auth,
        private readonly Filesystem $filesystem,
    ) {
    }

    public function register(string $login, string $email, string $password): User
    {
        $avatars = $this->filesystem
            ->disk(config('filesystems.avatar_mask.disk'))
            ->files(config('filesystems.avatar_mask.directory'));

        $user = User::register($login, $email, Password::create($password), Arr::random($avatars));

        $this->mailer->to($user->email)
            ->send(new VerifyRegistration($user));

        $this->eventDispatcher->dispatch(new Registered($user));

        $this->auth->login($user);
        return $user;
    }
    
    public function sendVerificationEmail(): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        if ($user->verify_token === null) {
            throw new VerificationNotRequested();
        }

        $this->mailer->to($user->email)
            ->send(new VerifyRegistration($user));
    }

    public function verifyRegistration(string $token): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        $user->verifyRegistration($token);

        $this->eventDispatcher->dispatch(new Verified($user));
    }
}
