<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\Article\Article;
use App\Models\User\Exceptions\BookmarkNotCreated;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveArticleBookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function testRemovePostFromBookmark(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached($user, relationship: 'usersBookmarked')
            ->create();

        $user->removeArticleBookmark($article);

        $this->assertNull($user->bookmarkedArticles()->find($article->id));
    }

    public function testRemoveNotBookmarkedPost(): void
    {
        $this->expectException(BookmarkNotCreated::class);

        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->create();

        $user->removeArticleBookmark($article);
    }
}
