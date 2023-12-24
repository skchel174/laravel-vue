<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCommentsIdsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticleCommentsIds(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $comments = Comment::factory(2)
            ->forArticle($article)
            ->create();

        Comment::factory()
            ->forComment($comments[0])
            ->create();

        $comment = Comment::factory()
            ->forComment($comments[1])
            ->create();

        Comment::factory()
            ->forComment($comment)
            ->create();

        $this->assertCount(5, $article->getCommentsIds());
    }
}
