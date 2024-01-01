<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\BookmarkedCommentsResource;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Service\CommentsService;
use Inertia\Inertia;
use Inertia\Response;

class CommentsController extends Controller
{
    public function __construct(private readonly CommentsService $service)
    {
    }

    public function index(User $user): Response
    {
        $comments = $this->service->getByAuthor($user);

        return Inertia::render('User/Comments/CommentsPage', [
            'user' => new UserResource($user),
            'comments' => new BookmarkedCommentsResource($comments),
        ]);
    }
}
