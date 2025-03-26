<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class IsEqualsTest extends TestCase
{
    public function testEqualsVerifyTokens(): void
    {
        $token = new VerifyToken(
            $value = fake()->uuid(),
            CarbonImmutable::now(),
        );

        $this->assertTrue($token->isEquals($value));
    }

    public function testNotEqualsVerifyTokens(): void
    {
        $token = new VerifyToken(
            fake()->uuid(),
            CarbonImmutable::now(),
        );

        $this->assertFalse($token->isEquals(fake()->uuid()));
    }
}
