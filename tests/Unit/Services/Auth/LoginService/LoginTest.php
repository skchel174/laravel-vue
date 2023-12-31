<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\LoginService;

use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\User;
use App\Service\Auth\LoginService;
use Database\Factories\User\UserFactory;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulLogin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $auth = $this->createMock(StatefulGuard::class);
        $auth->expects($this->once())
            ->method('login')
            ->with($user, $remember = false);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('regenerate');

        $service = new LoginService($auth, $session);

        $loggedUser = $service->login($user->login, UserFactory::PASSWORD, $remember);

        $this->assertInstanceOf(User::class, $loggedUser);
        $this->assertTrue($loggedUser->is($user));
    }

    public function testLoginUserByWrongPassword(): void
    {
        $this->expectException(ValidationException::class);

        /** @var User $user */
        $user = User::factory()->create();

        $auth = $this->createMock(StatefulGuard::class);

        $session = $this->createMock(Session::class);

        $service = new LoginService($auth, $session);

        $service->login($user->login, $this->faker->word(), false);
    }

    public function testLoginNotActiveUser(): void
    {
        $this->expectException(AccountNotActive::class);

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $auth = $this->createMock(StatefulGuard::class);

        $session = $this->createMock(Session::class);

        $service = new LoginService($auth, $session);

        $service->login($user->login, UserFactory::PASSWORD, false);
    }
}
