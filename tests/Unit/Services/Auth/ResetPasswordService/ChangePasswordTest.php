<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\ResetPasswordService;

use App\Events\User\PasswordReset;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Service\Auth\ResetPasswordService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Session\Session;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testChangePassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $password = 'new-password';

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByVerifyToken')
            ->with($user->verify_token->getValue())
            ->willReturn($user);

        $mailer = $this->createMock(Mailer::class);

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(PasswordReset::class));

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('invalidate');

        $service = new ResetPasswordService($repository, $mailer, $dispatcher, $session);

        $service->changePassword($password, $user->verify_token->getValue());

        $this->assertTrue($user->password->isEquals($password));
    }
}
