<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class IsEqualsTest extends TestCase
{
    use RefreshDatabase;

    public function testEqualsVerifyTokens(): void
    {
        /** @var VerifyToken $verifyToken */
        $verifyToken = VerifyToken::factory()->create([
            'token' => $token = Str::uuid()->toString(),
        ]);

        $this->assertTrue($verifyToken->isEquals($token));
    }

    public function testNotEqualsVerifyTokens(): void
    {
        /** @var VerifyToken $verifyToken */
        $verifyToken = VerifyToken::factory()->create();

        $this->assertFalse($verifyToken->isEquals(fake()->word()));
    }
}
