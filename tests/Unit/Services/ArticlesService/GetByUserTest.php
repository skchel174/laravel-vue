<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ArticlesService;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\Comment\Comment;
use App\Models\Topic\Topic;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GetByUserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticlesByUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached(Topic::factory())
            ->likedBy(User::factory()->create())
            ->likedBy(User::factory()->create())
            ->create([
                'author_id' => $user,
                'status' => $status = Status::Published,
            ]);

        Comment::factory(2)
            ->forArticle($article)
            ->create();

        Article::factory()->create([
            'status' => Status::Moderated,
        ]);

        $authService = $this->createAuthService($user);

        $service = new ArticlesService($authService);

        $paginator = $service->getByAuthor($user, $status);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertContainsOnlyInstancesOf(Article::class,  $paginator->items());
        $this->assertCount(1, $paginator->items());

        $userArticle = $paginator->items()[0];

        $this->assertTrue($article->is($userArticle));
        $this->assertTrue($userArticle->author->is($user));
        $this->assertEquals(Status::Published, $userArticle->status);
        $this->assertEquals(2, $userArticle->likes_count);
        $this->assertEquals(2, $userArticle->related_comments_count);
    }

    public function testGetArticleByIdForAuthenticatedUser()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $author */
        $author = User::factory()->create();

        Article::factory()
            ->hasAttached(Topic::factory())
            ->likedBy($user)
            ->bookmarkedBy($user)
            ->create(['author_id' => $author]);

        $authService = $this->createAuthService($user);

        $service = new ArticlesService($authService);

        $paginator = $service->getByAuthor($author, Status::Published);

        $article = $paginator->items()[0];

        $this->assertTrue($article->is_liked);
        $this->assertTrue($article->is_bookmarked);
    }

    private function createAuthService(?User $user = null): StatefulGuard
    {
        $service = $this->createMock(StatefulGuard::class);
        $service->expects($this->once())
            ->method('user')
            ->willReturn($user);

        return $service;
    }
}
