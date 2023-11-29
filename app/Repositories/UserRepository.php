<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function getByVerifyToken(string $token): User
    {
        return User::where('verify_token', $token)->firstOrFail();
    }
}
