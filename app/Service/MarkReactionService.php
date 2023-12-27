<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class MarkReactionService
{
    public function __construct(private readonly ArticleRepositoryInterface $articleRepository)
    {
    }

    public function markArticles(User $user, array|Arrayable $articles): void
    {
        $articlesIds = Arr::pluck($articles, 'id');
        $likesIds = $this->articleRepository->getLikesIds($user, $articlesIds);
        $bookmarksIds = $this->articleRepository->getBookmarksIds($user, $articlesIds);

        foreach ($articles as $article) {
            $article->is_liked = $likesIds->contains($article->id);
            $article->is_bookmarked = $bookmarksIds->contains($article->id);
        }
    }

    public function markArticle(User $user, Article $article): void
    {
        $article->is_liked = $user->likedArticles()
            ->where('id', $article->id)
            ->exists();

        $article->is_bookmarked = $user->bookmarkedArticles()
            ->where('id', $article->id)
            ->exists();
    }
}
