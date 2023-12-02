<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\PasswordUpdateService;

use App\Events\User\PasswordChanged;
use App\Models\User\User;
use App\Service\Profile\PasswordUpdateService;
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

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(PasswordChanged::class));

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('invalidate');

        $service = new PasswordUpdateService($dispatcher, $session);

        $service->changePassword($user, $password = 'new-password');

        $this->assertTrue($user->password->isEquals($password));
    }
}
