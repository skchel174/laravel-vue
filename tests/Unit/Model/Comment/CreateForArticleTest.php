<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Comment;

use App\Events\Comment\CommentCreated;
use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotPublished;
use App\Models\Article\Status as ArticleStatus;
use App\Models\Comment\Comment;
use App\Models\User\Exceptions\AccountNotActive;
use App\Models\User\Status as UserStatus;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class CreateForArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreateCommentForArticle(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        /** @var Article $article */
        $article = Article::factory()->create();

        Event::shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(fn ($arg) => $arg instanceof CommentCreated));

        $comment = Comment::createForArticle($article, $author, $text = $this->faker->text());

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($text, $comment->text);
        $this->assertTrue($comment->author->is($author));
        $this->assertTrue($comment->article->is($article));
        $this->assertTrue($comment->commentable->is($article));
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

        Event::shouldReceive('dispatch')->never();

        Comment::createForArticle($article, $author, $this->faker->text());
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

        Event::shouldReceive('dispatch')->never();

        Comment::createForArticle($article, $author, $this->faker->text());
    }
}
