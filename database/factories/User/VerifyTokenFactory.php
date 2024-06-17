<?php

declare(strict_types=1);

namespace Database\Factories\User;

use App\Models\User\User;
use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<VerifyToken>
 */
class VerifyTokenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'token' => Str::uuid(),
            'user_id' => User::factory(),
            'created_at' => CarbonImmutable::now(),
        ];
    }
}
