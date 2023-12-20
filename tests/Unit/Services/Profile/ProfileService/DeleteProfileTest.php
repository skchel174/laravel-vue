<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\ProfileService;

use App\Models\User\User;
use App\Service\Profile\ProfileService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteProfile(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $dispatcher = $this->createMock(Dispatcher::class);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('invalidate');
        $session->expects($this->once())
            ->method('regenerateToken');

        $auth = $this->createMock(StatefulGuard::class);
        $auth->expects($this->once())
            ->method('user')
            ->willReturn($user);
        $auth->expects($this->once())
            ->method('logout');

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->deleteProfile();

        $this->assertFalse($user->exists());
    }
}
