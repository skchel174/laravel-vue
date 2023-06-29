<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Post\Post;

use App\Models\Post\Exceptions\PostAlreadyPublishedException;
use App\Models\Post\Post;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulPublish(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $post->publish($date = CarbonImmutable::now());

        $this->assertNotNull($post->publish_date);
        $this->assertInstanceOf(CarbonImmutable::class, $post->publish_date);
        $this->assertEquals($date->getTimestamp(), $post->publish_date->getTimestamp());
        $this->assertDatabaseHas('posts', [
            'status' => $post->status = Post::PUBLISHED,
            'publish_date' => $post->publish_date->format('Y-m-d H:i:s'),
        ]);
    }

    public function testPublishAlreadyPublishedPost(): void
    {
        $this->expectException(PostAlreadyPublishedException::class);

        /** @var Post $post */
        $post = Post::factory()
            ->published()
            ->create();

        $post->publish(CarbonImmutable::now());
    }
}
