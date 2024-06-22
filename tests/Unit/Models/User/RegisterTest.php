<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

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
            $email = fake()->email(),
            $username = fake()->word(),
            $password = fake()->word(),
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->username, $username);
        $this->assertEquals($user->email, $email);
        $this->assertTrue($user->checkPassword($password));
        $this->assertEquals(Status::Wait, $user->status);
        $this->assertNotNull($user->verifyToken);
        $this->assertModelExists($user->verifyToken);
        $this->assertModelExists($user);
    }
}
