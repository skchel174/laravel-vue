<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\CommentRepository;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBookmarksIdsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarksIdsFromCommentsList(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        $comments = Comment::factory(5)
            ->withAuthor($user)
            ->bookmarkedBy($user)
            ->forArticle(Article::factory()->create())
            ->create();

        $repository = new CommentRepository();

        $commentsSlice = $comments->slice(0, $cnt = 2);

        $bookmarksIds = $repository->getBookmarksIds($user, $commentsSlice->pluck('id'));

        $this->assertNotEmpty($bookmarksIds);
        $this->assertCount($cnt, $bookmarksIds);
        $this->assertEmpty($bookmarksIds->diff($commentsSlice->pluck('id')));
    }
}
