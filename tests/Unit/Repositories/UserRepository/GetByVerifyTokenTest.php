<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\UserRepository;

use App\Models\User\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByVerifyTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUserByVerifyToken(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $repository = new UserRepository();

        $repositoryUser = $repository->getByVerifyToken($user->verify_token->getValue());

        $this->assertInstanceOf(User::class, $repositoryUser);
        $this->assertTrue($repositoryUser->is($user));
    }

    public function testGetUserByInvalidVerifyToken(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new UserRepository();

        $repository->getByVerifyToken($this->faker->word());
    }
}
