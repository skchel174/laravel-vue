<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ArticlesService;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetByIdTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticleById(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->likedBy(User::factory()->create())
            ->create();

        $comments = Comment::factory(3)
            ->forArticle($article)
            ->create();

        Auth::shouldReceive('user')
            ->once()
            ->andReturnNull();

        $service = new ArticlesService();

        $fetchedArticle = $service->getById($article->id);

        $this->assertInstanceOf(Article::class, $fetchedArticle);
        $this->assertTrue($article->is($fetchedArticle));
        $this->assertNull($fetchedArticle->is_liked);
        $this->assertNull($fetchedArticle->is_bookmarked);
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

        Auth::shouldReceive('user')
            ->once()
            ->andReturns($user);

        $service = new ArticlesService();

        $article = $service->getById($article->id);

        $this->assertTrue($article->is_liked);
        $this->assertTrue($article->is_bookmarked);
    }
}
