<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\RegisterService;

use App\Events\User\Verified;
use App\Models\User\User;
use App\Service\Auth\RegisterService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifyRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyRegistration(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(Verified::class));

        $mailer = $this->createMock(Mailer::class);
        $guard = $this->createMock(StatefulGuard::class);
        $filesystem = $this->createMock(Factory::class);

        $service = new RegisterService($mailer, $dispatcher, $guard, $filesystem);

        $service->verifyRegistration($user, $user->verify_token->getValue());

        $this->assertNull($user->verify_token);
    }
}
