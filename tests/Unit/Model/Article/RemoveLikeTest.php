<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotLiked;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveLikeTest extends TestCase
{
    use RefreshDatabase;

    public function testRemoveLikeFromArticle(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->likedBy($user)
            ->create();

        $article->removeLike($user);

        $this->assertFalse($article->likes()->where('id', $user->id)->exists());
    }


    public function testAttemptAddLikeForAlreadyLikedArticle(): void
    {
        $this->expectException(ArticleNotLiked::class);

        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->create();

        $article->removeLike($user);
    }
}
