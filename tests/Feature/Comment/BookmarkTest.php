<?php

declare(strict_types=1);

namespace Tests\Feature\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
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
        $user = User::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forCommentable(Article::factory()->create())
            ->create();

        $response = $this
            ->actingAs($user)
            ->post(route('api.comments.bookmark', [
                'comment' => $comment->id,
            ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNotNull($user->bookmarkedComments()->find($comment->id));
    }

    public function testRemoveArticleFromBookmarks(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forCommentable(Article::factory()->create())
            ->bookmarkedBy($user)
            ->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('api.comments.bookmark', [
                'comment' => $comment->id,
            ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull($user->bookmarkedComments()->find($comment->id));
    }
}
