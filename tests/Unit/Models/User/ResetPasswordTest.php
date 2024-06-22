<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\Exceptions\VerificationNotRequestedException;
use App\Models\User\Exceptions\VerificationTokenExpiredException;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulResetPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => $token = VerifyToken::create(),
        ]);

        $user->resetPassword(
            $password = fake()->word(),
            $token->getValue(),
        );

        $this->assertTrue($user->checkPassword($password));
        $this->assertNull($user->verify_token);
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
        $user = User::factory()->create([
            'verify_token' => $token = VerifyToken::create(),
        ]);

        Event::shouldReceive('dispatch')->never();

        $user->resetPassword(fake()->word(), $token->getValue());
    }
}
