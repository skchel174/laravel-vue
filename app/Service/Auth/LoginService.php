<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Session\Session;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function __construct(
        private readonly StatefulGuard $auth,
        private readonly Session $session,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function login(string $login, string $password, bool $remember): User
    {
        /** @var User $user */
        $user = User::whereLogin($login)->firstOrFail();

        if (!$user->password->isEquals($password)) {
            throw ValidationException::withMessages([
                'password' => 'The provided password is incorrect',
            ]);
        }

        if (!$user->status->isActive()) {
            throw new AccountNotActive();
        }

        $this->auth->login($user, $remember);

        $this->session->regenerate();

        return $user;
    }

    public function logout(): void
    {
        $this->auth->logout();

        $this->session->invalidate();

        $this->session->regenerateToken();
    }
}
