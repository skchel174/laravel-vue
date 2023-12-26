<?php

declare(strict_types=1);

namespace Tests\Feature\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewCommentForArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var User $author */
        $author = User::factory()->create();

        $response = $this
            ->from($fromUrl = route('article', ['id' => $article->id]))
            ->actingAs($author)
            ->post(route('articles.comment.create', ['article' => $article->id]), [
                'text' => $text = $this->faker->text(),
            ]);

        /** @var Comment $comment */
        $comment = $article->comments()->first();

        $response->assertRedirect($fromUrl);

        $response->assertSessionHasNoErrors();

        $this->assertNotNull($comment);

        $this->assertEquals($text, $comment->text);
    }

    public function testCreateNewCommentForComment(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var Comment $commentable */
        $commentable = Comment::factory()
            ->forArticle($article)
            ->create();

        /** @var User $author */
        $author = User::factory()->create();

        $response = $this
            ->from($fromUrl = route('article', ['id' => $article->id]))
            ->actingAs($author)
            ->post(
                route('articles.comment.reply', [
                    'article' => $article->id,
                    'comment' => $commentable->id,
                ]),
                [
                    'text' => $text = $this->faker->text(),
                ],
            );

        /** @var Comment $comment */
        $comment = $commentable->comments()->first();

        $response->assertRedirect($fromUrl);

        $response->assertSessionHasNoErrors();

        $this->assertNotNull($comment);

        $this->assertEquals($text, $comment->text);
    }
}
