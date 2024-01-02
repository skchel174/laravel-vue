<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Exceptions\User\InvalidVerificationToken;
use App\Exceptions\User\RegistrationAlreadyVerified;
use App\Exceptions\User\VerificationNotRequested;
use App\Exceptions\User\VerificationTokenExpired;
use App\Models\User\Status;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class VerifyRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyVerification(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verifyRegistration($user->verify_token->getValue());

        $this->assertNotEquals(Status::Wait, $user->status);
        $this->assertEquals(Status::Active, $user->status);
        $this->assertNull($user->verify_token);
    }

    public function testVerifyAlreadyVerifiedUser(): void
    {
        $this->expectException(RegistrationAlreadyVerified::class);

        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $user->verifyRegistration($user->verify_token->getValue());
    }

    public function testVerifyWhenVerificationNotRequested(): void
    {
        $this->expectException(VerificationNotRequested::class);

        /** @var User $user */
        $user = User::factory()->create([
            'status' => Status::Wait,
        ]);

        $user->verifyRegistration('invalid-token');
    }

    public function testVerifyByInvalidVerificationToken(): void
    {
        $this->expectException(InvalidVerificationToken::class);

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verifyRegistration('invalid-token');
    }

    public function testVerifyByExpiredToken(): void
    {
        $this->expectException(VerificationTokenExpired::class);

        Config::set('auth.verification_timeout', 0);

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verifyRegistration($user->verify_token->getValue());
    }
}
