<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Comment\BookmarkedCommentsResource;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Service\BookmarksService;
use Inertia\Inertia;
use Inertia\Response;

class BookmarksController extends Controller
{
    public function __construct(private readonly BookmarksService $bookmarksService)
    {
    }

    public function articles(User $user): Response
    {
        $articles = $this->bookmarksService->getArticles($user);

        return Inertia::render('User/Bookmarks/Articles/ArticlesPage', [
            'user' => new UserResource($user),
            'articles' => new ArticlesResource($articles),
        ]);
    }

    public function comments(User $user): Response
    {
        $comments = $this->bookmarksService->getComments($user);

        return Inertia::render('User/Bookmarks/Comments/CommentsPage', [
            'user' => new UserResource($user),
            'comments' => new BookmarkedCommentsResource($comments),
        ]);
    }
}
