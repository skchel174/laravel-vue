<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\Comment\CommentCardCollection;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UsersCollection;
use App\Models\Article\Status;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function profile(User $user): Response
    {
        $topics = $user->topics()
            ->withCount(['subscribers', 'articles'])
            ->get();

        return Inertia::render('User/Profile/ProfilePage', [
            'user' => new UserResource($user),
            'topics' => TopicResource::collection($topics),
        ]);
    }

    public function articles(User $user, Status $status = Status::Published): Response
    {
        if (!$status->isPublished() && !$user->is(Auth::user())) {
            throw new NotFoundHttpException();
        }

        $query = $user->articles();

        if (Auth::check()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId(Auth::id()),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        $articles = $query->with(['topics', 'cardImage'])
            ->withCount(['likes', 'relatedComments'])
            ->withTrashed($status === Status::Deleted)
            ->whereStatus($status)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();

        return Inertia::render('User/Articles/ArticlesPage', [
            'user' => new UserResource($user),
            'articles' => new ArticlesResource($articles),
            'status' => $status->value,
            'statuses' => Status::cases(),
        ]);
    }

    public function comments(User $user): Response
    {
        $query = $user->comments();

        if (Auth::check()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        $comments = $query->with('article')
            ->orderBy('id', 'desc')
            ->paginate();

        return Inertia::render('User/Comments/CommentsPage', [
            'user' => new UserResource($user),
            'comments' => new CommentCardCollection($comments),
        ]);
    }

    public function bookmarkedArticles(User $user): Response
    {
        $query = $user->bookmarkedArticles();

        if (Auth::check()) {
            $query->withExists([
                'likes as is_liked' => fn(Builder $query) => $query->whereId(Auth::id()),
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        $articles = $query->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
            ->orderBy('id', 'desc')
            ->paginate();

        return Inertia::render('User/Bookmarks/Articles/ArticlesPage', [
            'user' => new UserResource($user),
            'articles' => new ArticlesResource($articles),
        ]);
    }

    public function bookmarkedComments(User $user): Response
    {
        $query = $user->bookmarkedComments();

        if (Auth::check()) {
            $query->withExists([
                'bookmarks as is_bookmarked' => fn(Builder $query) => $query->whereId(Auth::id()),
            ]);
        }

        $comments = $query->with('article')
            ->orderBy('id', 'desc')
            ->paginate();

        return Inertia::render('User/Bookmarks/Comments/CommentsPage', [
            'user' => new UserResource($user),
            'comments' => new CommentCardCollection($comments),
        ]);
    }

    public function following(User $user): Response
    {
        $following = $user->following()
            ->paginate(30);

        return Inertia::render('User/Following/FollowingPage', [
            'user' => new UserResource($user),
            'users' => new UsersCollection($following),
        ]);
    }
}
