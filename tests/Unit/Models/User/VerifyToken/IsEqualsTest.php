<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsEqualsTest extends TestCase
{
    use RefreshDatabase;

    public function testEqualsVerifyTokens(): void
    {
        $token = VerifyToken::create();

        $value = $token->getValue();

        $this->assertTrue($token->isEquals($value));
    }

    public function testNotEqualsVerifyTokens(): void
    {
        $token = VerifyToken::create();

        $this->assertFalse($token->isEquals(fake()->word()));
    }
}
