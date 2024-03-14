<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\User\UsersCollection;
use App\Models\Article\Status as ArticleStatus;
use App\Models\User\Status as UserStatus;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthorController extends Controller
{
    public function authors(Request $request): Response
    {
        $query = User::query();

        if ($search = $request->query('search')) {
            $query
                ->where('username', 'like', "%$search%")
                ->orWhere('fullname', 'like', "%$search%");
        }

        $authors = $query
            ->withCount(['articles' => function (Builder $query) {
                $query->whereStatus(ArticleStatus::Published);
            }])
            ->having('articles_count', '>', 0)
            ->whereStatus(UserStatus::Active)
            ->orderByDesc('articles_count')
            ->paginate()
            ->withQueryString();

        Inertia::share('nav.location', 'articles');

        return Inertia::render('Articles/AuthorsPage', [
            'authors' => new UsersCollection($authors),
            'search' => $search,
        ]);
    }
}
