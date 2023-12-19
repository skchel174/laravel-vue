<?php

namespace App\Repositories\Interfaces;

use App\Models\User\User;

interface UserRepositoryInterface
{
    public function getByLogin(string $login): User;
    public function getByEmail(string $email): User;
    public function getByVerifyToken(string $token): User;
}
