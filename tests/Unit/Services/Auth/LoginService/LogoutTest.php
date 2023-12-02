<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\LoginService;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Service\Auth\LoginService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulLogout(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);

        $auth = $this->createMock(StatefulGuard::class);
        $auth->expects($this->once())
            ->method('logout');

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('invalidate');
        $session->expects($this->once())
            ->method('regenerateToken');

        $service = new LoginService($repository, $auth, $session);

        $service->logout();
    }
}
