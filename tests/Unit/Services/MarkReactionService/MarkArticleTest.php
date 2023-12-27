<?php

declare(strict_types=1);

namespace Tests\Unit\Services\MarkReactionService;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Service\MarkReactionService;
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

        $repository = $this->createMock(ArticleRepositoryInterface::class);

        $service = new MarkReactionService($repository);

        $service->markArticle($user, $article);

        $this->assertTrue($article->is_liked);
        $this->assertTrue($article->is_bookmarked);
    }
}
