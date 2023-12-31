<?php

declare(strict_types=1);

namespace Tests\Unit\Services\BookmarksService;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Service\BookmarksService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class GetCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarkedComments(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        $authService = $this->createAuthService();

        $service = new BookmarksService($authService);

        $paginator = $service->getComments($user);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertContainsOnlyInstancesOf(Comment::class, $paginator->items());
        $this->assertCount(1, $paginator->items());

        /** @var Comment $bookmarkedComment */
        $bookmarkedComment = $paginator->items()[0];

        $this->assertTrue($comment->is($bookmarkedComment));
        $this->assertTrue($user->is($comment->bookmarks()->first()));
        $this->assertNull($bookmarkedComment->is_bookmarked);
    }

    public function testGetBookmarkedCommentsForAuthenticatedUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $authenticatedUser */
        $authenticatedUser = User::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->bookmarkedBy($authenticatedUser)
            ->bookmarkedBy($user)
            ->create();

        $authService = $this->createAuthService($authenticatedUser);

        $service = new BookmarksService($authService);

        $paginator = $service->getComments($user);

        /** @var Comment $bookmarkedComment */
        $bookmarkedComment = $paginator->items()[0];

        $this->assertTrue($bookmarkedComment->is_bookmarked);
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
