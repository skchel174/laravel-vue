<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Events\User\PasswordReset;
use App\Exceptions\User\PasswordResetNotRequested;
use App\Exceptions\User\VerificationTokenExpired;
use App\Models\User\Password;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Mockery;
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

        Event::shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(function ($arg) use ($user) {
                return $arg instanceof PasswordReset && $arg->user->is($user);
            }));

        $user->resetPassword($password = Password::create($this->faker->word()));

        $this->assertNull($user->verify_token);
        $this->assertEquals($user->password->getHash(), $password->getHash());
    }

    public function testResetPasswordWithoutVerifyToken(): void
    {
        $this->expectException(PasswordResetNotRequested::class);

        /** @var User $user */
        $user = User::factory()->create();

        Event::shouldReceive('dispatch')->never();

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

        Event::shouldReceive('dispatch')->never();

        $user->resetPassword(Password::create($this->faker->word()));
    }
}
