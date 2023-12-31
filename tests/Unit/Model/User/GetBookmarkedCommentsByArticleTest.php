<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GetBookmarkedCommentsByArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarkedCommentsByArticle()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create();

        $bookmarkedComments = Comment::factory(3)
            ->forArticle($article)
            ->bookmarkedBy($user)
            ->create();

        Comment::factory(2)
            ->forArticle($article)
            ->create();

        $bookmarks = $user->getBookmarkedCommentsByArticle($article);

        $this->assertNotEmpty($bookmarks);
        $this->assertContainsOnlyInstancesOf(Comment::class, $bookmarks);
        $this->assertEmpty($bookmarkedComments->diff($bookmarks));
    }

    public function testGetEmptyBookmarkedCommentsByArticle()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create();

        Comment::factory(2)
            ->forArticle($article)
            ->create();

        $bookmarks = $user->getBookmarkedCommentsByArticle($article);

        $this->assertEmpty($bookmarks);
    }
}
