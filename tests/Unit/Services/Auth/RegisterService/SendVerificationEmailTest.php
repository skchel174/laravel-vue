<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\RegisterService;

use App\Mail\VerifyRegistration;
use App\Models\User\Exceptions\VerificationNotRequested;
use App\Models\User\User;
use App\Service\Auth\RegisterService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendVerificationEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testSendVerificationEmail(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
            ->method('to')
            ->with($user->email)
            ->willReturn($mailer);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(VerifyRegistration::class));

        $dispatcher = $this->createMock(Dispatcher::class);
        $guard = $this->createMock(StatefulGuard::class);
        $filesystem = $this->createMock(Factory::class);

        $service = new RegisterService($mailer, $dispatcher, $guard, $filesystem);

        $service->sendVerificationEmail($user);
    }

    public function testSendEmailWhenVerificationNotRequested(): void
    {
        $this->expectException(VerificationNotRequested::class);

        /** @var User $user */
        $user = User::factory()->create();

        $mailer = $this->createMock(Mailer::class);
        $dispatcher = $this->createMock(Dispatcher::class);
        $guard = $this->createMock(StatefulGuard::class);
        $filesystem = $this->createMock(Factory::class);

        $service = new RegisterService($mailer, $dispatcher, $guard, $filesystem);

        $service->sendVerificationEmail($user);
    }
}
