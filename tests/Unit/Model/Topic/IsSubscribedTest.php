<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Topic;

use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsSubscribedTest extends TestCase
{
    use RefreshDatabase;

    public function testTrue(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Topic $topic */
        $topic = Topic::factory()
            ->hasAttached($user, relationship: 'subscribers')
            ->create();

        $this->assertTrue($topic->isSubscribed($user));
    }

    public function testFalse(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Topic $topic */
        $topic = Topic::factory()->create();

        $this->assertFalse($topic->isSubscribed($user));
    }
}
