<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCommentsIdsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetChildCommentsIds(): void
    {
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create();

        $comments = Comment::factory(2)
            ->forComment($comment)
            ->create();

        Comment::factory()
            ->forComment($comments[0])
            ->create();

        Comment::factory()
            ->forComment(Comment::factory()->forComment($comments[1])->create())
            ->create();

        $comment->refresh();

        $this->assertCount(5, $comment->getCommentsIds());
    }
}
