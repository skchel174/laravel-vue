<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookmarkController extends Controller
{
    public function make(Article $article): JsonResponse
    {
        Auth::user()->makeArticleBookmark($article);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Article $article): JsonResponse
    {
        Auth::user()->removeArticleBookmark($article);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
