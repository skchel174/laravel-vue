<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\Exceptions\VerificationNotRequestedException;
use App\Models\User\Exceptions\VerificationTokenExpiredException;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulResetPassword(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withVerifyToken()
            ->create();

        $user->resetPassword(
            $password = fake()->word(),
            $user->verifyToken->token,
        );

        $this->assertNull($user->verifyToken);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    public function testResetPasswordWithoutVerifyToken(): void
    {
        $this->expectException(VerificationNotRequestedException::class);

        /** @var User $user */
        $user = User::factory()->create();

        $user->resetPassword(fake()->word(), 'verify-token');
    }

    public function testResetPasswordByExpiredVerifyToken(): void
    {
        $this->expectException(VerificationTokenExpiredException::class);

        Config::set('auth.verification_timeout', 0);

        /** @var User $user */
        $user = User::factory()
            ->withVerifyToken()
            ->create();

        Event::shouldReceive('dispatch')->never();

        $user->resetPassword(fake()->word(), $user->verifyToken->token);
    }
}
