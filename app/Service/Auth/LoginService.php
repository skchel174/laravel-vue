<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly StatefulGuard $auth,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function login(string $email, string $password, bool $remember): User
    {
        $user = $this->repository->getByEmail($email);

        if (!$user->password->isEquals($password)) {
            throw ValidationException::withMessages([
                'password' => 'The provided password is incorrect',
            ]);
        }

        if (!$user->status->isActive()) {
            throw new AccountNotActive();
        }

        $this->auth->login($user, $remember);

        return $user;
    }

    public function logout(): void
    {
        $this->auth->logout();
    }
}
