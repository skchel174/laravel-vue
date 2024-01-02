<?php

declare(strict_types=1);

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Article\Article;
use App\Models\Comment\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(CreateCommentRequest $request, Article $article): RedirectResponse
    {
        Comment::createForArticle($article, Auth::user(), $request->text);

        return redirect()->back();
    }

    public function reply(CreateCommentRequest $request, Article $article, Comment $comment): RedirectResponse
    {
        Comment::createForComment($comment, Auth::user(), $request->text);

        return redirect()->back();
    }

    public function edit(UpdateCommentRequest $request, Article $article, Comment $comment): RedirectResponse
    {
        $comment->edit($request->text);

        return redirect()->back();
    }
}
