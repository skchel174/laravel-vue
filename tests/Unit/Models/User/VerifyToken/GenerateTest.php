<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class GenerateTest extends TestCase
{
    public function testGenerateVerifyToken(): void
    {
        $token = VerifyToken::generate($lifetime = 3600);

        $this->assertNotEmpty($token->getValue());
        $this->assertEquals(
            $token->getExpirationDate()->format('Y-m-d H:i'),
            CarbonImmutable::now()->addSeconds($lifetime)->format('Y-m-d H:i'),
        );
    }
}

