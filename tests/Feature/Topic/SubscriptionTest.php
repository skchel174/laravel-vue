<?php

declare(strict_types=1);

namespace Tests\Feature\Topic;

use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testSubscribeUserToTopic(): void
    {
        /** @var Topic $topic */
        $topic = Topic::factory()->create();

        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('api.topics.subscription', ['topic' => $topic->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testUnsubscribeUserFromForm(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Topic $topic */
        $topic = Topic::factory()
            ->hasAttached($user, relationship: 'subscribers')
            ->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('api.topics.subscription', ['topic' => $topic->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
