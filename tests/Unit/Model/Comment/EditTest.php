<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Comment;

use App\Events\Comment\CommentUpdated;
use App\Exceptions\Comment\ExceededEditingTimeLimit;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyUpdateComment(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create(['created_at' => CarbonImmutable::now()]);

        Event::shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(fn ($arg) => $arg instanceof CommentUpdated));

        $comment->edit($text = $this->faker->text());

        $this->assertEquals($text, $comment->text);
    }

    public function testUpdateNotEditableComment(): void
    {
        $this->expectException(ExceededEditingTimeLimit::class);

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create(['created_at' => CarbonImmutable::now()->subDays(31)]);

        Event::shouldReceive('dispatch')->never();

        $comment->edit($text = $this->faker->text());

        $this->assertNotEquals($text, $comment->text);
    }
}
