<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\Comment\Comment;
use App\Models\User\User;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Arr;

class MarkReactionService
{
    public function __construct(private readonly CommentRepositoryInterface $commentRepository)
    {
    }

    public function markArticle(User $user, Article $article): void
    {
        $article->is_liked = $article->isLiked($user);
        $article->is_bookmarked = $user->isArticleBookmarked($article);
    }

    /**
     * @param User $user
     * @param iterable<Article> $articles
     * @return void
     */
    public function markArticles(User $user, iterable $articles): void
    {
        $articlesIds = Arr::pluck($articles, 'id');

        $likesIds = $user->likedArticles()
            ->whereIn('id', $articlesIds)
            ->whereStatus(Status::Published)
            ->pluck('id');

        $bookmarksIds = $user->bookmarkedArticles()
            ->whereIn('id', $articlesIds)
            ->whereStatus(Status::Published)
            ->pluck('id');

        foreach ($articles as $article) {
            $article->is_liked = $likesIds->contains($article->id);
            $article->is_bookmarked = $bookmarksIds->contains($article->id);
        }
    }

    /**
     * @param User $user
     * @param iterable<Comment> $comments
     * @return void
     */
    public function markComments(User $user, iterable $comments): void
    {
        $commentsIds = Arr::pluck($comments, 'id');
        $bookmarkedComments = $this->commentRepository->getBookmarksIds($user, $commentsIds);

        foreach ($comments as $comment) {
            $comment->is_bookmarked = $bookmarkedComments->contains($comment->id);
        }
    }
}
