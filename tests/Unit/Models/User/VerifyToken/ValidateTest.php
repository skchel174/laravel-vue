<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use DomainException;
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

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Verify token is invalid.');

        $token->validate(fake()->uuid(), $expiresAt);
    }

    public function testTokenIsExpired(): void
    {
        $token = new VerifyToken(
            $value = fake()->uuid(),
            $expiresAt = CarbonImmutable::now()
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Verify token is expired.');

        $token->validate($value, $expiresAt->addSecond());
    }
}
