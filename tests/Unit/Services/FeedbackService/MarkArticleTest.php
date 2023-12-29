<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FeedbackService;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Service\FeedbackService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testMarkArticle(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()
            ->likedBy($user)
            ->bookmarkedBy($user)
            ->create();

        $articleRepository = $this->createMock(ArticleRepositoryInterface::class);
        $commentRepository = $this->createMock(CommentRepositoryInterface::class);

        $service = new FeedbackService($articleRepository, $commentRepository);

        $service->markArticle($user, $article);

        $this->assertTrue($article->is_liked);
        $this->assertTrue($article->is_bookmarked);
    }
}
