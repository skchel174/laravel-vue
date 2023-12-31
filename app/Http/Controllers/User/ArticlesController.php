<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Service\ArticlesService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticlesController extends Controller
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly ArticlesService $articlesService,
    ) {
    }

    public function index(User $user, Status $status = Status::Published): Response
    {
        /** @var User $authUser */
        $authUser = $this->authService->user();
        if (!$status->isPublished() && !$user->is($authUser)) {
            throw new NotFoundHttpException();
        }

        $articles = $this->articlesService->getByAuthor($user, $status);

        return Inertia::render('User/Articles/ArticlesPage', [
            'user' => new UserResource($user),
            'articles' => new ArticlesResource($articles),
            'status' => $status->value,
            'statuses' => Status::cases(),
        ]);
    }
}
