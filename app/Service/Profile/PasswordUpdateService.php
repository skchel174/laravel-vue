<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\Events\User\PasswordChanged;
use App\Models\User\Password;
use App\Models\User\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;

class PasswordUpdateService
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
        private readonly Session $session,
    ) {
    }

    public function changePassword(User $user, string $newPassword): void
    {
        $user->update([
            'password' => Password::create($newPassword),
        ]);

        $this->dispatcher->dispatch(new PasswordChanged($user));

        $this->session->invalidate();
    }
}
