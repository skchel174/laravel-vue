<?php

declare(strict_types=1);

namespace App\Service;

use App\Events\Comment\CreateComment;
use App\Events\Comment\UpdateComment;
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

        $comment = Comment::createForComment($comment, $user, $text);

        $this->eventDispatcher->dispatch(new CreateComment($comment));

        return $comment;
    }

    public function edit(Comment $comment, string $text): Comment
    {
        $comment->edit($text);

        $this->eventDispatcher->dispatch(new UpdateComment($comment));

        return $comment;
    }
}
