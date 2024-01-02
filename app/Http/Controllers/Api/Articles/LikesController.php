<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LikesController extends Controller
{
    public function add(Article $article): JsonResponse
    {
        $article->addLike(Auth::user());

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Article $article): JsonResponse
    {
        $article->removeLike(Auth::user());

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
