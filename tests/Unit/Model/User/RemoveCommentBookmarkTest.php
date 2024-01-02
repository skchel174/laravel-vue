<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Exceptions\User\BookmarkNotCreated;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveCommentBookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function testRemoveCommentFromBookmark(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        $user->removeCommentBookmark($comment);

        $this->assertNull($user->bookmarkedComments()->find($comment->id));
    }

    public function testRemoveNotBookmarkedComment(): void
    {
        $this->expectException(BookmarkNotCreated::class);

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create();

        $user->removeCommentBookmark($comment);
    }
}
