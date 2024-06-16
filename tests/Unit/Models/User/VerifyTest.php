<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\Exceptions\AccountVerifiedException;
use App\Models\User\Exceptions\InvalidVerifyTokenException;
use App\Models\User\Exceptions\VerificationNotRequestedException;
use App\Models\User\Exceptions\VerificationTokenExpiredException;
use App\Models\User\Status;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyVerification(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verify($user->verifyToken->token);

        $this->assertEquals(Status::Active, $user->status);
        $this->assertNull($user->verifyToken);
    }

    public function testVerifyAlreadyVerifiedUser(): void
    {
        $this->expectException(AccountVerifiedException::class);

        /** @var User $user */
        $user = User::factory()
            ->withVerifyToken()
            ->create();

        $user->verify($user->verifyToken->token);
    }

    public function testVerifyWhenVerificationNotRequested(): void
    {
        $this->expectException(VerificationNotRequestedException::class);

        /** @var User $user */
        $user = User::factory()->create([
            'status' => Status::Wait,
        ]);

        $user->verify('invalid-token');
    }

    public function testVerifyByInvalidVerificationToken(): void
    {
        $this->expectException(InvalidVerifyTokenException::class);

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verify('invalid-token');
    }

    public function testVerifyByExpiredToken(): void
    {
        $this->expectException(VerificationTokenExpiredException::class);

        Config::set('auth.verification_timeout', 0);

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verify($user->verifyToken->token);
    }
}
