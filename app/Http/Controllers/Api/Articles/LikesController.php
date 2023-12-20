<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LikesController extends Controller
{
    public function __construct(private readonly StatefulGuard $auth)
    {
    }

    public function add(Article $article): JsonResponse
    {
        /** @var User $user */
        $user = $this->auth->user();

        $article->addLike($user);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Article $article): JsonResponse
    {
        /** @var User $user */
        $user = $this->auth->user();

        $article->removeLike($user);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
