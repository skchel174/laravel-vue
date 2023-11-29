<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth\LoginService;

use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Service\Auth\LoginService;
use Database\Factories\User\UserFactory;
use Illuminate\Contracts\Auth\StatefulGuard;
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

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByEmail')
            ->with($user->email)
            ->willReturn($user);

        $auth = $this->createMock(StatefulGuard::class);
        $auth->expects($this->once())
            ->method('login')
            ->with($user, $remember = false);

        $service = new LoginService($repository, $auth);

        $loggedUser = $service->login($user->email, UserFactory::PASSWORD, $remember);

        $this->assertInstanceOf(User::class, $loggedUser);
        $this->assertTrue($loggedUser->is($user));
    }

    public function testLoginUserByWrongPassword(): void
    {
        $this->expectException(ValidationException::class);

        /** @var User $user */
        $user = User::factory()->create();

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByEmail')
            ->with($user->email)
            ->willReturn($user);

        $auth = $this->createMock(StatefulGuard::class);

        $service = new LoginService($repository, $auth);

        $service->login($user->email, $this->faker->word(), false);
    }

    public function testLoginNotActiveUser(): void
    {
        $this->expectException(AccountNotActive::class);

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByEmail')
            ->with($user->email)
            ->willReturn($user);

        $auth = $this->createMock(StatefulGuard::class);

        $service = new LoginService($repository, $auth);

        $service->login($user->email, UserFactory::PASSWORD, false);
    }
}
