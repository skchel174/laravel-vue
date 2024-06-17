<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\Password;

use App\Models\User\Password;
use Tests\TestCase;

class MakeTest extends TestCase
{
    public function testPasswordHashNotEqualsProvidedPassword(): void
    {
        $password = Password::make($value = fake()->word());

        $this->assertNotEquals($value, $password->getHash());
    }
}
