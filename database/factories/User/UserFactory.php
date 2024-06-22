<?php

declare(strict_types=1);

namespace Database\Factories\User;

use App\Models\User\Status;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    const PASSWORD = 'password';

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->word(),
            'password' => Hash::make(static::PASSWORD),
            'status' => Status::Active,
        ];
    }

    public function withVerifyToken(): static
    {
        return $this->has(VerifyToken::factory());
    }

    public function unverified(): static
    {
        return $this->state(['status' => Status::Wait])->withVerifyToken();
    }
}
