<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Comment;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotPublished;
use App\Models\Article\Status as ArticleStatus;
use App\Models\Comment\Comment;
use App\Models\Comment\Exception\NotBelongsToArticle;
use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\Status as UserStatus;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateForCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreateCommentForComment(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var Comment $commentable */
        $commentable = Comment::factory()
            ->forArticle($article)
            ->create();

        $comment = Comment::createForComment($commentable, $article, $author, $text = $this->faker->text());

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($text, $comment->text);
        $this->assertTrue($comment->author->is($author));
        $this->assertTrue($comment->article->is($article));
        $this->assertTrue($comment->commentable->is($commentable));
        $this->assertTrue($comment->exists());
    }

    public function testCreateCommentByNotActivatedAuthor(): void
    {
        $this->expectException(AccountNotActive::class);

        /** @var User $author */
        $author = User::factory()->create([
            'status' => UserStatus::Wait,
        ]);

        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle($article)
            ->create();

        Comment::createForComment($comment, $article, $author, $this->faker->text());
    }

    public function testCreateCommentForNotPublishedArticle(): void
    {
        $this->expectException(ArticleNotPublished::class);

        /** @var User $author */
        $author = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create([
            'status' => ArticleStatus::Moderated,
        ]);

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle($article)
            ->create();

        Comment::createForComment($comment, $article, $author, $this->faker->text());
    }

    public function testCreateCommentForInvalidArticle(): void
    {
        $this->expectException(NotBelongsToArticle::class);

        /** @var User $author */
        $author = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()
            ->forArticle(Article::factory()->create())
            ->create();

        Comment::createForComment($comment, $article, $author, $this->faker->text());
    }
}
