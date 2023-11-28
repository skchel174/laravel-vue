<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\VerifyToken;

use App\Models\User\VerifyToken;
use Tests\TestCase;

class IsEqualsTest extends TestCase
{
    public function testEqualsVerifyToken(): void
    {
        $token = VerifyToken::create();

        $this->assertTrue($token->isEquals($token->getValue()));
    }

    public function testNotEqualsVerifyToken(): void
    {
        $token = VerifyToken::create();

        $this->assertFalse($token->isEquals($this->faker->word()));
    }
}
