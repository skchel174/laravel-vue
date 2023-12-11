<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Topic;

use App\Models\Topic\Exceptions\UserNotSubscribed;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnsubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyUnsubscribeUser(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Topic $topic */
        $topic = Topic::factory()
            ->hasAttached($user, relationship: 'subscribers')
            ->create();

        $topic->unsubscribe($user);

        $this->assertFalse($topic->subscribers()->where('id', $user->id)->exists());
    }

    public function testAttemptSubscribeAlreadySubscribedUser(): void
    {
        $this->expectException(UserNotSubscribed::class);

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Topic $topic */
        $topic = Topic::factory()->create();

        $topic->unsubscribe($user);

        $this->assertTrue($topic->subscribers()->where('id', $user->id)->exists());
    }
}
