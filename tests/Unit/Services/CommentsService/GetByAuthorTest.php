<?php

declare(strict_types=1);

namespace Tests\Unit\Services\CommentsService;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Service\CommentsService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GetByAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function testGetPaginatedCommentsByAuthor(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        /** @var Collection<Comment> $comments */
        $comments = Comment::factory(5)
            ->withAuthor($author)
            ->forArticle(Article::factory()->create())
            ->create();

        $auth = $this->createAuthService(null);

        $service = new CommentsService($auth);

        $paginator = $service->getByAuthor($author);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);

        $paginatorItems = Collection::make($paginator->items());

        $this->assertContainsOnlyInstancesOf(Comment::class, $paginatorItems);
        $this->assertCount($comments->count(), $paginatorItems);
        $this->assertEmpty($comments->diff($paginatorItems));
    }

    public function testGetCommentsByAuthorForAuthenticatedUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $author */
        $author = User::factory()->create();

        Comment::factory(3)
            ->withAuthor($author)
            ->forArticle(Article::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        $auth = $this->createAuthService($user);

        $service = new CommentsService($auth);

        $paginator = $service->getByAuthor($author);

        foreach ($paginator->items() as $comment) {
            /** @var Comment $comment */
            $this->assertTrue($comment->is_bookmarked);
        }
    }

    private function createAuthService(?User $user): StatefulGuard
    {
        $service = $this->createMock(StatefulGuard::class);
        $service->expects($this->once())
            ->method('user')
            ->willReturn($user);

        return $service;
    }
}
