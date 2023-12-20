<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleAlreadyLiked;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddLikeTest extends TestCase
{
    use RefreshDatabase;

    public function testAddLikeForArticle(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->create();

        $article->addLike($user);

        $this->assertTrue($article->usersLiked()->where('id', $user->id)->exists());
    }


    public function testAttemptAddLikeForAlreadyLikedArticle(): void
    {
        $this->expectException(ArticleAlreadyLiked::class);

        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->likedBy($user)
            ->create();

        $article->addLike($user);
    }
}
