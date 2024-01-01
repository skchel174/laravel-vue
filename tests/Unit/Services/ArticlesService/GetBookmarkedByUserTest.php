<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ArticlesService;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\Comment\Comment;
use App\Models\Topic\Topic;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetBookmarkedByUserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookmarkedArticles(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        Auth::shouldReceive('user')
            ->once()
            ->andReturn(null);

        Article::factory()
            ->create(['status' => Status::Moderated]);

        /** @var Collection<Article> $articles */
        $articles = Article::factory(2)
            ->bookmarkedBy($user)
            ->likedBy(User::factory()->create())
            ->likedBy(User::factory()->create())
            ->create([
                'author_id' => $user,
                'status' => $status = Status::Published,
            ]);

        Comment::factory(3)
            ->forArticle($articles[0])
            ->create();

        Comment::factory(3)
            ->forArticle($articles[1])
            ->create();

        $service = new ArticlesService();

        $paginator = $service->getByAuthor($user, $status);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertContainsOnlyInstancesOf(Article::class,  $paginator->items());
        $this->assertCount($articles->count(), $paginator->items());

        foreach (Collection::make($paginator->items()) as $article) {
            /** @var Article $article */
            $this->assertTrue($user->bookmarkedArticles()->whereId($article->id)->exists());
            $this->assertEquals(Status::Published, $article->status);
            $this->assertEquals(2, $article->likes_count);
            $this->assertEquals(3, $article->related_comments_count);
        }
    }

    public function testGetBookmarkedArticlesForAuthenticatedUser(): void
    {
        /** @var User $authUser */
        $authUser = User::factory()->create();

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($authUser);

        Article::factory(2)
            ->likedBy($authUser)
            ->bookmarkedBy($authUser)
            ->bookmarkedBy($user = User::factory()->create())
            ->create();

        $service = new ArticlesService();
        $paginator = $service->getBookmarkedByUser($user);

        foreach (Collection::make($paginator->items()) as $article) {
            /** @var Article $article */
            $this->assertTrue($article->is_liked);
            $this->assertTrue($article->is_bookmarked);
        }
    }
}
