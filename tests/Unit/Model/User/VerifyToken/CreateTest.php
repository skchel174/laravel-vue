<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testCreateVerifyToken(): void
    {
        $token = VerifyToken::create();

        $this->assertIsString($token->getValue());
        $this->assertNotEmpty($token->getValue());
        $this->assertInstanceOf(CarbonImmutable::class, $token->getDate());
    }
}
