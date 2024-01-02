<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Events\User\EmailChanged;
use App\Exceptions\User\InvalidVerificationToken;
use App\Exceptions\User\VerificationNotRequested;
use App\Exceptions\User\VerificationTokenExpired;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class VerifyNewEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyNewEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'new_email' => $email = $this->faker->email(),
            'verify_token' => $token = VerifyToken::create(),
        ]);

        Event::shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(function ($arg) use ($user) {
                return $arg instanceof EmailChanged && $arg->user->is($user);
            }));

        $user->verifyNewEmail($token->getValue());

        $this->assertEquals($user->email, $email);
        $this->assertNull($user->new_email);
        $this->assertNull($user->verify_token);
    }

    public function testVerifyEmailWithoutVerifyToken(): void
    {
        $this->expectException(VerificationNotRequested::class);

        /** @var User $user */
        $user = User::factory()->create([
            'new_email' => $this->faker->email(),
        ]);

        Event::shouldReceive('dispatch')->never();

        $user->verifyNewEmail($this->faker->word());
    }

    public function testVerifyEmailByInvalidVerifyToken(): void
    {
        $this->expectException(InvalidVerificationToken::class);

        Event::shouldReceive('dispatch')->never();
        /** @var User $user */
        $user = User::factory()->create([
            'new_email' => $this->faker->email(),
            'verify_token' => VerifyToken::create(),
        ]);

        $user->verifyNewEmail($this->faker->word());
    }

    public function testResetPasswordByExpiredVerifyToken(): void
    {
        $this->expectException(VerificationTokenExpired::class);

        Config::set('auth.verification_timeout', 0);

        /** @var User $user */
        $user = User::factory()->create([
            'new_email' => $this->faker->email(),
            'verify_token' => $token = VerifyToken::create(),
        ]);

        Event::shouldReceive('dispatch')->never();

        $user->verifyNewEmail($token->getValue());
    }
}
