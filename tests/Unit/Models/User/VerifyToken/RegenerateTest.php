<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegenerateTest extends TestCase
{
    use RefreshDatabase;

    public function testRegenerateVerifyToken(): void
    {
        /** @var VerifyToken $token */
        $token = VerifyToken::factory()->create([
            'token' => $oldToken = Str::uuid(),
            'created_at' => $oldDate = CarbonImmutable::now(),
        ]);

        $token->regenerate();

        $this->assertNotEquals($oldToken, $token->token);
        $this->assertTrue($oldDate->ne($token->created_at));
    }
}
