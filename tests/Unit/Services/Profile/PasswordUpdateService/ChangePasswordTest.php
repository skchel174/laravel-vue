<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\PasswordUpdateService;

use App\Events\User\PasswordChanged;
use App\Models\User\User;
use App\Service\Profile\PasswordUpdateService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Session\Session;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testChangePassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $dispatcher = $this->createDispatcher();
        $session = $this->createSession();
        $auth = $this->createAuthService($user);

        $service = new PasswordUpdateService($dispatcher, $session, $auth);

        $service->changePassword($password = 'new-password');

        $this->assertTrue($user->password->isEquals($password));
    }

    private function createDispatcher(): Dispatcher
    {
        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(PasswordChanged::class));

        return $dispatcher;
    }

    private function createSession(): Session
    {
        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('invalidate');

        return $session;
    }

    private function createAuthService(User $user): StatefulGuard
    {
        $service = $this->createMock(StatefulGuard::class);
        $service->expects($this->once())
            ->method('user')
            ->willReturn($user);

        return $service;
    }
}
