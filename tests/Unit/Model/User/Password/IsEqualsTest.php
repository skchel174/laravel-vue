<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\Password;

use App\Models\User\Password;
use Tests\TestCase;

class IsEqualsTest extends TestCase
{
    public function testCheckWhenPasswordsAreEquals(): void
    {
        $password = Password::create($value = $this->faker->word());

        $this->assertTrue($password->isEquals($value));
    }

    public function testCheckWhenPasswordsAreNotEquals(): void
    {
        $password = Password::create($this->faker->word());

        $this->assertFalse($password->isEquals($this->faker->word()));
    }
}
