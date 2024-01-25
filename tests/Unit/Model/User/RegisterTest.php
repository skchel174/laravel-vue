<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Events\User\UserRegistered;
use App\Models\User\Password;
use App\Models\User\Status;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterNewUser(): void
    {
        $login = $this->faker->word();
        $email = $this->faker->email();
        $password = $this->faker->word();

        Event::shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(function ($arg) use ($login) {
                return $arg instanceof UserRegistered && $arg->user->login === $login;
            }));

        $user = User::register($login, $email, Password::create($password));

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->login, $login);
        $this->assertEquals($user->email, $email);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals(Status::Wait, $user->status);
        $this->assertNotNull($user->verify_token);
        $this->assertModelExists($user);
    }
}
