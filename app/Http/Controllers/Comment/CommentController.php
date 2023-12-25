<?php

declare(strict_types=1);

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Service\CommentService;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __construct(private readonly CommentService $service)
    {
    }

    public function create(CreateCommentRequest $request, Article $article): RedirectResponse
    {
        $comment = $this->service->createForArticle($article, $request->text);

        $url = sprintf(
            '%s#comment_%d',
            route('article', ['id' => $article->id]),
            $comment->id
        );

        return redirect($url);
    }

    public function reply(CreateCommentRequest $request, Article $article, Comment $comment): RedirectResponse
    {
        $comment = $this->service->createForComment($comment, $article, $request->text);

        $url = sprintf(
            '%s#comment_%d',
            route('article', ['id' => $article->id]),
            $comment->id
        );

        return redirect($url);
    }
}
