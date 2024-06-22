<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsExpiredTest extends TestCase
{
    use RefreshDatabase;

    public function testExpiredToken(): void
    {
        $token = VerifyToken::create();

        $this->assertTrue($token->isExpired(0));
    }

    public function testNotExpiredToken(): void
    {
        $token = VerifyToken::create();

        $this->assertFalse($token->isExpired(1000));
    }
}
