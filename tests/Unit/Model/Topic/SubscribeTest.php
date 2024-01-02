<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Topic;

use App\Exceptions\Topic\UserAlreadySubscribed;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullySubscribeUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Topic $topic */
        $topic = Topic::factory()->create();

        $topic->subscribe($user);

        $this->assertTrue($topic->subscribers()->where('id', $user->id)->exists());
    }

    public function testAttemptSubscribeAlreadySubscribedUser(): void
    {
        $this->expectException(UserAlreadySubscribed::class);

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Topic $topic */
        $topic = Topic::factory()
            ->hasAttached($user, relationship: 'subscribers')
            ->create();

        $topic->subscribe($user);

        $this->assertFalse($topic->subscribers()->where('id', $user->id)->exists());
    }
}
