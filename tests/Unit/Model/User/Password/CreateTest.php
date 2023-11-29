<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\Password;

use App\Models\User\Password;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testCreateNewPassword(): void
    {
        $password = Password::create($value = $this->faker->word());

        $this->assertTrue(Hash::isHashed($password->getHash()));
        $this->assertNotEquals($value, $password->getHash());
        $this->assertTrue(Hash::check($value, $password->getHash()));
    }
}
