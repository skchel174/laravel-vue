<?php

declare(strict_types=1);

namespace App\Service;

use App\Events\Article\CreateComment;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;

class CommentService
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly Dispatcher $eventDispatcher,
    ) {
    }

    public function createForArticle(Article $article, string $text): Comment
    {
        /** @var User $user */
        $user = $this->authService->user();

        $comment = Comment::createForArticle($article, $user, $text);

        $this->eventDispatcher->dispatch(new CreateComment($comment));

        return $comment;
    }

    public function createForComment(Comment $comment, Article $article, string $text): Comment
    {
        /** @var User $user */
        $user = $this->authService->user();

        $comment = Comment::createForComment($comment, $article, $user, $text);

        $this->eventDispatcher->dispatch(new CreateComment($comment));

        return $comment;
    }
}
