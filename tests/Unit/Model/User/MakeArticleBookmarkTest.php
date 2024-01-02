<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Exceptions\Article\ArticleNotPublished;
use App\Exceptions\User\BookmarkAlreadyCreated;
use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeArticleBookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function testAddArticleToBookmarks(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->create();

        /** @var User $user */
        $user = User::factory()
            ->create();

        $user->makeArticleBookmark($article);

        $this->assertNotNull($user->bookmarkedArticles()->find($article->id));
    }

    public function testAddNotPublishedArticleToBookmarks(): void
    {
        $this->expectException(ArticleNotPublished::class);

        /** @var Article $article */
        $article = Article::factory()
            ->create(['status' => Status::Moderated]);

        /** @var User $user */
        $user = User::factory()
            ->create();

        $user->makeArticleBookmark($article);
    }

    public function testAddToBookmarksAlreadyBookmarkedArticle(): void
    {
        $this->expectException(BookmarkAlreadyCreated::class);

        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached($user, relationship: 'bookmarks')
            ->create();

        $user->makeArticleBookmark($article);
    }
}
