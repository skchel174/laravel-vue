<?php

declare(strict_types=1);

namespace Tests\Unit\Services\MarkReactionService;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Service\MarkReactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function testMarkArticles(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Comment $comment01 */
        $comment01 = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        /** @var Comment $comment02 */
        $comment02 = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create();

        $articleRepository = $this->createMock(ArticleRepositoryInterface::class);
        $commentRepository = $this->createCommentRepository($user);

        $service = new MarkReactionService($articleRepository, $commentRepository);

        $service->markComments($user, [$comment01, $comment02]);

        $this->assertTrue($comment01->is_bookmarked);
        $this->assertFalse($comment02->is_bookmarked);
    }

    private function createCommentRepository(User $user): CommentRepositoryInterface
    {
        $repository = $this->createMock(CommentRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBookmarksIds')
            ->willReturn($user->bookmarkedComments()->pluck('id'));

        return $repository;
    }
}
