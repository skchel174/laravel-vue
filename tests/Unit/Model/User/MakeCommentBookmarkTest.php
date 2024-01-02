<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Exceptions\User\BookmarkAlreadyCreated;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeCommentBookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function testAddArticleToBookmarks(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create();

        $user->makeCommentBookmark($comment);

        $this->assertNotNull($user->bookmarkedComments()->find($comment->id));
    }

    public function testAddToBookmarksAlreadyBookmarkedArticle(): void
    {
        $this->expectException(BookmarkAlreadyCreated::class);

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        $user->makeCommentBookmark($comment);

        $this->assertNull($user->bookmarkedComments()->find($comment->id));
    }
}
