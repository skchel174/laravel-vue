<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\User\Exceptions\PasswordResetNotRequested;
use App\Models\User\Exceptions\VerificationTokenExpired;
use App\Models\User\Password;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulResetPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $user->resetPassword($password = Password::create($this->faker->word()));

        $this->assertNull($user->verify_token);
        $this->assertEquals($user->password->getHash(), $password->getHash());
    }

    public function testResetPasswordWithoutVerifyToken(): void
    {
        $this->expectException(PasswordResetNotRequested::class);

        /** @var User $user */
        $user = User::factory()->create();

        $user->resetPassword(Password::create($this->faker->word()));
    }

    public function testResetPasswordByExpiredVerifyToken(): void
    {
        $this->expectException(VerificationTokenExpired::class);

        Config::set('auth.password_timeout', 0);

        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $user->resetPassword(Password::create($this->faker->word()));
    }
}
