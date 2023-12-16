<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookmarkController extends Controller
{
    public function __construct(private readonly StatefulGuard $authService)
    {
    }

    public function make(Article $article): JsonResponse
    {
        /** @var User $user */
        $user = $this->authService->user();
        $user->makeArticleBookmark($article);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Article $article): JsonResponse
    {
        /** @var User $user */
        $user = $this->authService->user();
        $user->removeArticleBookmark($article);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
