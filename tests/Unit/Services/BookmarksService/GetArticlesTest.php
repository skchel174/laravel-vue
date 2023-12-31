<?php

declare(strict_types=1);

namespace Tests\Unit\Services\BookmarksService;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\Topic\Topic;
use App\Models\User\User;
use App\Service\BookmarksService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarkedArticles(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached(Topic::factory())
            ->likedBy(User::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        Comment::factory(2)
            ->forArticle($article)
            ->create();

        $authService = $this->createAuthService();

        $service = new BookmarksService($authService);

        $paginator = $service->getArticles($user);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertContainsOnlyInstancesOf(Article::class, $paginator->items());
        $this->assertCount(1, $paginator->items());

        /** @var Article $bookmarkedArticle */
        $bookmarkedArticle = $paginator->items()[0];

        $this->assertTrue($article->is($bookmarkedArticle));
        $this->assertNotEmpty($bookmarkedArticle->topics);
        $this->assertTrue($user->is($article->bookmarks()->first()));
        $this->assertEquals(1, $bookmarkedArticle->likes_count);
        $this->assertEquals(2, $bookmarkedArticle->related_comments_count);
        $this->assertNull($bookmarkedArticle->is_liked);
        $this->assertNull($bookmarkedArticle->is_bookmarked);
    }

    public function testGetBookmarkedArticlesForAuthenticatedUser(): void
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = User::factory()->create();

        Article::factory()
            ->likedBy($authenticatedUser)
            ->bookmarkedBy($authenticatedUser)
            ->bookmarkedBy($user = User::factory()->create())
            ->create();

        $authService = $this->createAuthService($authenticatedUser);

        $service = new BookmarksService($authService);

        $paginator = $service->getArticles($user);

        /** @var Article $bookmarkedArticle */
        $bookmarkedArticle = $paginator->items()[0];

        $this->assertTrue($bookmarkedArticle->is_liked);
        $this->assertTrue($bookmarkedArticle->is_bookmarked);
    }

    private function createAuthService(?User $user = null): StatefulGuard
    {
        $service = $this->createMock(StatefulGuard::class);
        $service->expects($this->once())
            ->method('user')
            ->willReturn($user);

        return $service;
    }
}
