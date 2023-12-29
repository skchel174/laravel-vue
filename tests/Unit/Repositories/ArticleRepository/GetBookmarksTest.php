<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\ArticleRepository;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class GetBookmarksTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarkedArticles(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        $bookmarkedArticles = Article::factory($cnt = 3)
            ->hasAttached($user, relationship: 'bookmarks')
            ->create();

        Article::factory(2)
            ->hasAttached($user, relationship: 'bookmarks')
            ->create(['status' => Status::Deleted]);

        $repository = new ArticleRepository();

        $articles = $repository->getBookmarks($user);

        $this->assertInstanceOf(LengthAwarePaginator::class, $articles);
        $this->assertNotEmpty($articles->items());
        $this->assertCount($cnt, $articles->items());
        $this->assertEmpty($bookmarkedArticles->diff($articles->items()));
    }
}
