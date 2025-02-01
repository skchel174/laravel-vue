<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class IsExpiredTest extends TestCase
{
    public function testExpiredToken(): void
    {
        $token = new VerifyToken(
            fake()->uuid(),
            $expiresAt = CarbonImmutable::now(),
        );

        $this->assertTrue($token->isExpired($expiresAt->addSecond()));
    }

    public function testNotExpiredToken(): void
    {
        $token = new VerifyToken(
            fake()->uuid(),
            $expiresAt = CarbonImmutable::now(),
        );

        $this->assertFalse($token->isExpired($expiresAt->subSecond()));
    }
}
