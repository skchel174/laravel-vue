<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticlesResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Service\FeedbackService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\StatefulGuard;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticlesController extends Controller
{
    public function __construct(
        private readonly StatefulGuard $authService,
        private readonly FeedbackService $reactionService,
    ) {
    }

    /**
     * @throws AuthenticationException
     */
    public function index(User $user, Status $status = Status::Published): Response
    {
        /** @var User|null $authUser */
        $authUser = $this->authService->user();

        if (!$status->isPublished() && !$user->is($authUser)) {
            throw new NotFoundHttpException();
        }

        $articles = $user->articles()
            ->with(['topics'])
            ->withCount(['likes', 'relatedComments'])
            ->withTrashed($status === Status::Deleted)
            ->whereStatus($status)
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();

        if ($authUser) {
            $this->reactionService->markArticles($authUser, $articles->items());
        }

        return Inertia::render('User/Articles/ArticlesPage', [
            'user' => new UserResource($user),
            'articles' => new ArticlesResource($articles),
            'status' => $status->value,
            'statuses' => Status::cases(),
        ]);
    }
}
