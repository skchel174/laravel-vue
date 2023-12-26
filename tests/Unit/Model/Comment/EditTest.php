<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\Comment\Exception\ExceededEditingTimeLimit;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $comment->edit($text = $this->faker->text());

        $this->assertNotEquals($text, $comment->text);
    }
}
