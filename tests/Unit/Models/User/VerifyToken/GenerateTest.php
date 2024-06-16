<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateTest extends TestCase
{
    use RefreshDatabase;

    public function testGenerateNewVerifyToken(): void
    {
        $token = VerifyToken::generate();

        $this->assertInstanceOf(VerifyToken::class, $token);
        $this->assertNotEmpty($token->token);
        $this->assertInstanceOf(CarbonImmutable::class, $token->created_at);
    }
}
