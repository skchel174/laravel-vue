<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\ResetPasswordService;

use App\Mail\ResetPassword;
use App\Models\User\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Service\Auth\ResetPasswordService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Session\Session;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendVerificationEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testSendVerificationEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByEmail')
            ->with($user->email)
            ->willReturn($user);

        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
            ->method('to')
            ->with($user->email)
            ->willReturn($mailer);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(ResetPassword::class));

        $dispatcher = $this->createMock(Dispatcher::class);

        $session = $this->createMock(Session::class);

        $service = new ResetPasswordService($repository, $mailer, $dispatcher, $session);

        $service->sendVerificationEmail($user->email);
    }
}
