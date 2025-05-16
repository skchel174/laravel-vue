<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\Exceptions\InvalidTokenException;
use App\Models\User\Exceptions\VerificationExpiredException;
use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use Tests\TestCase;

class ValidateTest extends TestCase
{
    #[DoesNotPerformAssertions]
    public function testSuccessfulValidation(): void
    {
        $token = new VerifyToken(
            $value = fake()->uuid(),
            $expiresAt = CarbonImmutable::now()
        );

        $token->validate($value, $expiresAt->subSecond());
    }

    public function testInvalidValue(): void
    {
        $token = new VerifyToken(
            fake()->uuid(),
            $expiresAt = CarbonImmutable::now()
        );

        $this->expectException(InvalidTokenException::class);

        $token->validate(fake()->uuid(), $expiresAt);
    }

    public function testTokenIsExpired(): void
    {
        $token = new VerifyToken(
            $value = fake()->uuid(),
            $expiresAt = CarbonImmutable::now()
        );

        $this->expectException(VerificationExpiredException::class);

        $token->validate($value, $expiresAt->addSecond());
    }
}
