<?php

declare(strict_types=1);

namespace Tests\Feature\Article;

use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function testAddPostToUserBookmarks(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->post(route('api.articles.bookmark', [
                'article' => $article->id,
            ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRemoveArticleFromBookmarks(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached($user, relationship: 'usersBookmarked')
            ->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('api.articles.bookmark', [
                'article' => $article->id,
            ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
