<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\Events\User\PasswordChanged;
use App\Models\User\Password;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;

class PasswordUpdateService
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
        private readonly Session $session,
        private readonly StatefulGuard $auth,
    ) {
    }

    public function changePassword(string $password): void
    {
        /** @var User $user */
        $user = $this->auth->user();

        $user->update([
            'password' => Password::create($password),
        ]);

        $this->dispatcher->dispatch(new PasswordChanged($user));

        $this->session->invalidate();
    }
}
