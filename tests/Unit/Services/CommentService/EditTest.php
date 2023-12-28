<?php

declare(strict_types=1);

namespace Tests\Unit\Services\CommentService;

use App\Events\Comment\UpdateComment;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Service\CommentService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testEditComment(): void
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

        $authService = $this->createMock(StatefulGuard::class);

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UpdateComment::class));

        $service = new CommentService($authService, $dispatcher);

        $comment = $service->edit($comment, $text = $this->faker->text());

        $this->assertEquals($text, $comment->text);
    }
}
