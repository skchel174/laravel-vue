<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeSubscription(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $follower */
        $follower = User::factory()->create();

        $response = $this
            ->actingAs($follower)
            ->post(route('api.users.subscription', ['user' => $user->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertTrue($follower->following()->where('id', $user->id)->exists());
    }

    public function testRemoveSubscription(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $follower */
        $follower = User::factory()
            ->withFollowing($user)
            ->create();

        $response = $this
            ->actingAs($follower)
            ->delete(route('api.users.subscription', ['user' => $user->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertFalse($follower->following()->where('id', $user->id)->exists());
    }
}
