<?php

declare(strict_types=1);

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleRepositoryInterface $articleRepository)
    {
    }

    public function index(int $id): Response
    {
        $article = $this->articleRepository->getById($id);

        return Inertia::render('Article/ArticlePage', [
            'article' => new ArticleResource($article),
        ]);
    }
}
