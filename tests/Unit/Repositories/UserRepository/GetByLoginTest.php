<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\UserRepository;

use App\Models\User\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUserByLogin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $repository = new UserRepository();

        $repositoryUser = $repository->getByLogin($user->login);

        $this->assertInstanceOf(User::class, $repositoryUser);
        $this->assertTrue($repositoryUser->is($user));
    }

    public function testGetUserByInvalidLogin(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new UserRepository();

        $repository->getByLogin($this->faker->word());
    }
}
