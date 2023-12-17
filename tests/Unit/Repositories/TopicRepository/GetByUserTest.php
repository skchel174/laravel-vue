<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\TopicRepository;

use App\Models\Article\Article;
use App\Models\Topic\Topic;
use App\Models\User\User;
use App\Repositories\TopicRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByUserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetTopicsByUser(): void
    {
        Topic::factory(2)
            ->hasAttached($users = User::factory(10)->create(), relationship: 'subscribers')
            ->hasAttached($articles = Article::factory(10)->create())
            ->create();

        $repository = new TopicRepository();

        /** @var User $user */
        $user = $users->first();

        $topics = $repository->getByUser($user);

        $this->assertNotEmpty($topics);
        $this->assertContainsOnlyInstancesOf(Topic::class, $topics);
        $this->assertEquals($user->topics()->pluck('id'), $topics->pluck('id'));
        $this->assertEquals($users->count(), $topics->first()->subscribers_count);
        $this->assertEquals($articles->count(), $topics->first()->articles_count);
    }
}
