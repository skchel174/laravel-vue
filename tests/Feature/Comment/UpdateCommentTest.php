<?php

declare(strict_types=1);

namespace Tests\Feature\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyUpdateComment(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->withAuthor($author)
            ->forArticle($article)
            ->create(['created_at' => CarbonImmutable::now()]);

        $response = $this
            ->from($fromUrl = route('article', ['id' => $article->id]))
            ->actingAs($author)
            ->patch(route('articles.comment.update', [
                'article' => $article->id,
                'comment' => $comment->id,
            ]), [
                'text' => $text = $this->faker->text(),
            ]);

        $comment->refresh();

        $response->assertRedirect($fromUrl);

        $response->assertSessionHasNoErrors();

        $this->assertEquals($text, $comment->text);
    }

    public function testUpdatingCommentNotByItsAuthor(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle($article)
            ->create(['created_at' => CarbonImmutable::now()]);

        /** @var User $author */
        $author = User::factory()->create();

        $response = $this
            ->from(route('article', ['id' => $article->id]))
            ->actingAs($author)
            ->patch(route('articles.comment.update', [
                'article' => $article->id,
                'comment' => $comment->id,
            ]), [
                'text' => $text = $this->faker->text(),
            ]);

        $comment->refresh();

        $response->assertForbidden();

        $this->assertNotEquals($text, $comment->text);
    }
}
