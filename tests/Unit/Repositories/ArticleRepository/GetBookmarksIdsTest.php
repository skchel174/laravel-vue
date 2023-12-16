<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\ArticleRepository;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBookmarksIdsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarkedArticlesIds(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        $bookmarkedArticles = Article::factory($cnt = 3)
            ->hasAttached($user, relationship: 'usersBookmarked')
            ->create();

        $repository = new ArticleRepository();

        $bookmarksIds = $repository->getBookmarksIds($user);

        $this->assertNotEmpty($bookmarksIds);
        $this->assertCount($cnt, $bookmarksIds);
        $this->assertEmpty($bookmarksIds->diff($bookmarkedArticles->pluck('id')));
    }

    public function testGetBookmarksIdsFromArticlesList(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        $bookmarkedArticles = Article::factory(5)
            ->hasAttached($user, relationship: 'usersBookmarked')
            ->create();

        $repository = new ArticleRepository();

        $articlesSlice = $bookmarkedArticles
            ->slice(0, $cnt = 2);

        $bookmarksIds = $repository->getBookmarksIds($user, $articlesSlice->pluck('id'));

        $this->assertNotEmpty($bookmarksIds);
        $this->assertCount($cnt, $bookmarksIds);
        $this->assertEmpty($bookmarksIds->diff($articlesSlice->pluck('id')));
    }
}
