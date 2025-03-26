<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\VerifyToken;

use App\Models\User\VerifyToken;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Tests\TestCase;

class MakeTest extends TestCase
{
    public function testVerifyTokenIsSuccessfulMade(): void
    {
        $token = new VerifyToken(
            $value = fake()->uuid(),
            $expiresAt = CarbonImmutable::now(),
        );

        $this->assertEquals($value, $token->getValue());
        $this->assertEquals($expiresAt, $token->getExpirationDate());
    }
}
