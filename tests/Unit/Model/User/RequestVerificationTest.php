<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function testRequestVerification(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->requestVerification();

        $this->assertNotNull($user->verify_token);
        $this->assertInstanceOf(VerifyToken::class, $user->verify_token);
    }
}
