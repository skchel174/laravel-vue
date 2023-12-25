<?php

declare(strict_types=1);

namespace Tests\Unit\Services\CommentService;

use App\Events\Article\CreateComment;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Service\CommentService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateForArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCommentForArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        /** @var User $author */
        $author = User::factory()->create();

        $authService = $this->createMock(StatefulGuard::class);
        $authService->expects($this->once())
            ->method('user')
            ->willReturn($author);

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(CreateComment::class));

        $service = new CommentService($authService, $dispatcher);

        $comment = $service->createForArticle($article, $text = $this->faker->text());

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($text, $comment->text);
        $this->assertTrue($comment->author->is($author));
        $this->assertTrue($comment->article->is($article));
        $this->assertTrue($comment->commentable->is($article));
    }
}
