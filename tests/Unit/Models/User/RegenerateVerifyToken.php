<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\Exceptions\VerificationNotRequestedException;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegenerateVerifyToken extends TestCase
{
    use RefreshDatabase;

    public function testRegenerateVerifyToken(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::generate(3600),
        ]);

        $oldToken = $user->verify_token;

        $user->regenerateVerifyToken();

        $this->assertNotNull($user->verify_token);
        $this->assertNotEquals($user->verify_token->getValue(), $oldToken->getValue());
    }

    public function testRegenerateNotExistsVerifyToken(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->expectException(VerificationNotRequestedException::class);

        $user->regenerateVerifyToken();
    }
}
