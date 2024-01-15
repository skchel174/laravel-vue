<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Exceptions\User\SubscriptionNotExists;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnfollowTest extends TestCase
{
    use RefreshDatabase;

    public function testUnfollow(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $follower */
        $follower = User::factory()
            ->withFollowing($user)
            ->create();

        $follower->unfollow($user);

        $this->assertFalse($follower->followings()->where('id', $user->id)->exists());
    }

    public function testUnfollowWhenSubscriptionNotExists(): void
    {
        $this->expectException(SubscriptionNotExists::class);

        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $follower */
        $follower = User::factory()->create();

        $follower->unfollow($user);
    }
}
