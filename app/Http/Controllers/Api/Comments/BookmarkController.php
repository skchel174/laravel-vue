<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookmarkController extends Controller
{
    public function __construct(private readonly StatefulGuard $authService)
    {
    }

    public function make(Comment $comment): JsonResponse
    {
        /** @var User $user */
        $user = $this->authService->user();

        $user->makeCommentBookmark($comment);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Comment $comment): JsonResponse
    {
        /** @var User $user */
        $user = $this->authService->user();

        $user->removeCommentBookmark($comment);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
