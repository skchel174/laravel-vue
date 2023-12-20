<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsLikedTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckIfArticleLikedByUser(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->likedBy($user)
            ->create();

        $this->assertTrue($article->isLiked($user));
    }

    public function testCheckIfArticleNotLikedByUser(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->create();

        $this->assertFalse($article->isLiked($user));
    }
}
