<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\RegisterService;

use App\Mail\VerifyRegistration;
use App\Models\User\User;
use App\Service\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testRegisterUser(): void
    {
        $login = $this->faker->word();
        $email = $this->faker->email();
        $password = $this->faker->word();
        $avatar = $this->faker->filePath();

        $mailer = $this->createMailer($email);
        $guard = $this->createStatefulGuard($email);
        $filesystem = $this->createFilesystem($avatar);
        $dispatcher = $this->createDispatcher();

        $service = new RegisterService($mailer, $dispatcher, $guard, $filesystem);

        $user = $service->register($login, $email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($login, $user->login);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($avatar, $user->avatar_mask);
        $this->assertTrue($user->password->isEquals($password));
        $this->assertModelExists($user);
    }

    private function createMailer(string $email): Mailer
    {
        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
            ->method('to')
            ->with($email)
            ->willReturn($mailer);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(VerifyRegistration::class));

        return $mailer;
    }

    private function createDispatcher(): Dispatcher
    {
        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(Registered::class));

        return $dispatcher;
    }

    private function createStatefulGuard(string $email): StatefulGuard
    {
        $guard = $this->createMock(StatefulGuard::class);
        $guard->expects($this->once())
            ->method('login')
            ->with($this->callback(function (User $user) use ($email) {
                return $user->email === $email;
            }));

        return $guard;
    }

    private function createFilesystem(string $avatar): Factory
    {
        $filesystem = $this->createMock(Filesystem::class);
        $filesystem->expects($this->once())
            ->method('files')
            ->with(config('filesystems.avatar_mask.directory'))
            ->willReturn([$avatar]);

        $factory = $this->createMock(Factory::class);
        $factory->expects($this->once())
            ->method('disk')
            ->with(config('filesystems.avatar_mask.disk'))
            ->willReturn($filesystem);

        return $factory;
    }
}
