<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\User\Password;
use App\Models\User\Status;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterNewUser(): void
    {
        $user = User::register(
            $name = $this->faker->name(),
            $email = $this->faker->email(),
            Password::create('secret')
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->name, $name);
        $this->assertEquals($user->email, $email);
        $this->assertEquals(Status::Wait, $user->status);
        $this->assertNotNull($user->verify_token);
        $this->assertModelExists($user);
    }
}
