<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\VerifyToken;

use App\Models\User\VerifyToken;
use Tests\TestCase;

class IsExpiredTest extends TestCase
{
    public function testCheckExpiredToken(): void
    {
        $token = VerifyToken::create();

        $this->assertTrue($token->isExpired(0));
    }

    public function testCheckNotExpiredToken(): void
    {
        $token = VerifyToken::create();

        $this->assertFalse($token->isExpired(1000));
    }
}
