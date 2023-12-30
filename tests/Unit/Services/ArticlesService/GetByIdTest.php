<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ArticlesService;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\Tag\Tag;
use App\Models\Topic\Topic;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByIdTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticleById(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached(Tag::factory())
            ->hasAttached(Topic::factory())
            ->likedBy(User::factory()->create())
            ->create();

        $comments = Comment::factory(3)
            ->forArticle($article)
            ->create();

        $authService = $this->createAuthService();

        $service = new ArticlesService($authService);

        $fetchedArticle = $service->getById($article->id);

        $this->assertInstanceOf(Article::class, $fetchedArticle);
        $this->assertTrue($article->is($fetchedArticle));
        $this->assertNull($fetchedArticle->is_liked);
        $this->assertNull($fetchedArticle->is_bookmarked);
        $this->assertNotEmpty($fetchedArticle->tags);
        $this->assertNotEmpty($fetchedArticle->topics);
        $this->assertEquals(1, $fetchedArticle->likes_count);
        $this->assertEquals($fetchedArticle->related_comments_count, $comments->count());
    }

    public function testGetArticleByIdForAuthenticatedUser()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()
            ->likedBy(User::factory()->create())
            ->bookmarkedBy($user)
            ->likedBy($user)
            ->create();

        $authService = $this->createAuthService($user);

        $service = new ArticlesService($authService);

        $fetchedArticle = $service->getById($article->id);

        $this->assertTrue($fetchedArticle->is_liked);
        $this->assertTrue($fetchedArticle->is_bookmarked);
        $this->assertEquals(2, $fetchedArticle->likes_count);
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
