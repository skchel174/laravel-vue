<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\Password;

use App\Models\User\Password;
use Tests\TestCase;

class IsEqualsTest extends TestCase
{
    public function testPasswordsEquals(): void
    {
        $password = Password::make($value = fake()->word());

        $this->assertTrue($password->isEquals($value));
    }

    public function testPasswordsNotEquals(): void
    {
        $password = Password::make(fake()->word());

        $this->assertFalse($password->isEquals(fake()->word()));
    }
}
