<?php

declare(strict_types=1);

namespace Database\Factories\User;

use App\Models\User\Password;
use App\Models\User\Status;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    const PASSWORD = 'secret';

    public function definition(): array
    {
        return [
            'login' => fake()->unique()->word(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Password::create(self::PASSWORD),
            'name' => fake()->name(),
            'about' => fake()->text(50),
            'remember_token' => Str::random(10),
            'status' => Status::Active,
            'created_at' => $createdAt = $this->faker->dateTimeBetween('-1 year'),
            'login_at' => $this->faker->dateTimeBetween($createdAt),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verify_token' => VerifyToken::create(),
            'status' => Status::Wait,
        ]);
    }

    public function withFollowing(User $user): static
    {
        return $this->hasAttached($user, relationship: 'followings');
    }
}
