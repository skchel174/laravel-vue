<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsEditTest extends TestCase
{
    use RefreshDatabase;

    public function testEditableComment(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create(['created_at' => CarbonImmutable::now()]);

        $this->assertTrue($comment->isEditable(CarbonImmutable::now()));
    }

    public function testNotEditableComment(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create(['created_at' => CarbonImmutable::now()->subDays(31)]);

        $this->assertFalse($comment->isEditable(CarbonImmutable::now()));
    }
}
