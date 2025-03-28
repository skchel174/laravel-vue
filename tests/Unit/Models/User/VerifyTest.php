<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\Exceptions\AlreadyVerifiedException;
use App\Models\User\Exceptions\InvalidTokenException;
use App\Models\User\Exceptions\VerificationExpiredException;
use App\Models\User\Exceptions\VerificationNotRequestedException;
use App\Models\User\Status;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulVerification(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $user->verify($user->verify_token->getValue());

        $this->assertEquals(Status::Active, $user->status);
        $this->assertNull($user->verify_token);
    }

    public function testVerificationWithAlreadyActiveStatus(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->expectException(AlreadyVerifiedException::class);
        $user->verify('test-token');
    }

    public function testVerificationWithoutVerifyToken(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'status' => Status::Wait,
        ]);

        $this->expectException(VerificationNotRequestedException::class);
        $user->verify('test-token');
    }

    public function testVerificationWithInvalidToken(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $this->expectException(InvalidTokenException::class);
        $user->verify('test-token');
    }

    public function testVerificationWithExpiredToken(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'status' => Status::Wait,
            'verify_token' => new VerifyToken(
                fake()->uuid(),
                CarbonImmutable::now()->subMinute()
            ),
        ]);

        $this->expectException(VerificationExpiredException::class);
        $user->verify($user->verify_token->getValue());
    }
}
