<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Exceptions\User\UnableFollowYourself;
use App\Exceptions\User\SubscriptionAlreadyExists;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    public function testSubscribeForUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $follower */
        $follower = User::factory()->create();

        $follower->follow($user);

        $this->assertTrue($follower->following()->where('id', $user->id)->exists());
    }

    public function testMakeSelfSubscription(): void
    {
        $this->expectException(UnableFollowYourself::class);

        /** @var User $user */
        $user = User::factory()->create();

        $user->follow($user);

        $this->assertFalse($user->following()->where('id', $user->id)->exists());
    }

    public function testMakeAlreadyExistsSubscription(): void
    {
        $this->expectException(SubscriptionAlreadyExists::class);

        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $follower */
        $follower = User::factory()
            ->withFollowing($user)
            ->create();

        $follower->follow($user);

        $this->assertFalse($follower->following()->where('id', $user->id)->exists());
    }
}
