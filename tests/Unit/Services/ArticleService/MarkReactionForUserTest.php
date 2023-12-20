<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ArticleService;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Service\ArticleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class MarkReactionForUserTest extends TestCase
{
    use RefreshDatabase;

    public function testMarkReactionForUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article01 */
        $article01 = Article::factory()
            ->likedBy($user)
            ->create();

        /** @var Article $article02 */
        $article02 = Article::factory()
            ->bookmarkedBy($user)
            ->create();

        $repository = $this->createArticleRepository($user);

        $service = new ArticleService($repository);

        $service->markReactionForUser($user, Collection::make([$article01, $article02]));

        $this->assertTrue($article01->is_liked);
        $this->assertFalse($article01->is_bookmarked);

        $this->assertFalse($article02->is_liked);
        $this->assertTrue($article02->is_bookmarked);
    }

    private function createArticleRepository(User $user): ArticleRepositoryInterface
    {
        $repository = $this->createMock(ArticleRepositoryInterface::class);

        $repository->expects($this->once())
            ->method('getBookmarksIds')
            ->willReturn($user->bookmarkedArticles->pluck('id'));

        $repository->expects($this->once())
            ->method('getLikesIds')
            ->willReturn($user->likedArticles->pluck('id'));

        return $repository;
    }
}
