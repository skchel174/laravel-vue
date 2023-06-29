<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Post\Post;

use App\Casts\Content;
use App\Casts\Title;
use App\Models\Post\Category;
use App\Models\Post\Channel;
use App\Models\Post\Post;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Symfony\Component\String\s;

class CreateFromChannelTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreate(): void
    {
        $faker = $this->getFaker();

        $post = Post::createFromChannel(
            /** @var Channel $channel */
            $channel = Channel::factory()->create(),
            $title = Title::create($faker->sentence(3)),
            $content = Content::create($faker->text(), $faker->text()),
            $pubDate = CarbonImmutable::now(),
            $link = $faker->url(),
            $categories = Category::factory()->count(2)->create()
        );

        $this->assertInstanceOf(Post::class, $post);
        $this->assertModelExists($post);
        $this->assertIsInt($post->id);
        $this->assertTrue($post->channel->is($channel));
        $this->assertEquals($post->title, $title);
        $this->assertEquals($post->content, $content);
        $this->assertEquals(Post::PUBLISHED, $post->status);
        $this->assertEquals($post->publish_date->getTimestamp(), $pubDate->getTimestamp());
        $this->assertEquals($post->link, $link);
        $this->assertCount($categories->count(), $post->categories);
        $this->assertEquals($categories->pluck('id'), $post->categories->pluck('id'));
    }
}
