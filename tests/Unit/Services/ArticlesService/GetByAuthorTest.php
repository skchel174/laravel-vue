<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ArticlesService;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\Comment\Comment;
use App\Models\Topic\Topic;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetByAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticlesByUser(): void
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
            $this->assertTrue($article->author->is($user));
            $this->assertEquals(Status::Published, $article->status);
            $this->assertEquals(2, $article->likes_count);
            $this->assertEquals(3, $article->related_comments_count);
        }
    }

    public function testGetArticlesForAuthenticatedUser()
    {
        /** @var User $user */
        $user = User::factory()->create();

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        /** @var User $author */
        $author = User::factory()->create();

        Article::factory(3)
            ->hasAttached(Topic::factory())
            ->likedBy($user)
            ->bookmarkedBy($user)
            ->create(['author_id' => $author]);

        $service = new ArticlesService();

        $paginator = $service->getByAuthor($author, Status::Published);

        foreach (Collection::make($paginator->items()) as $article) {
            /** @var Article $article */
            $this->assertTrue($article->is_liked);
            $this->assertTrue($article->is_bookmarked);
        }
    }
}
