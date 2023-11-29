<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\RegisterService;

use App\Mail\VerifyRegistration;
use App\Models\User\User;
use App\Service\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->email();
        $password = $this->faker->word();

        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
            ->method('to')
            ->with($email)
            ->willReturn($mailer);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(VerifyRegistration::class));

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(Registered::class));

        $guard = $this->createMock(StatefulGuard::class);
        $guard->expects($this->once())
            ->method('login')
            ->with($this->callback(function (User $user) use ($email) {
                return $user->email === $email;
            }));

        $service = new RegisterService($mailer, $dispatcher, $guard);

        $user = $service->register($name, $email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertTrue($user->password->isEquals($password));
        $this->assertModelExists($user);
    }
}
