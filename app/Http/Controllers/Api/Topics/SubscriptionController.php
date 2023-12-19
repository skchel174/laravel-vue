<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Topics;

use App\Http\Controllers\Controller;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function __construct(private readonly StatefulGuard $auth)
    {
    }

    public function make(Topic $topic): JsonResponse
    {
        /** @var User $user */
        $user = $this->auth->user();

        $topic->subscribe($user);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Topic $topic): JsonResponse
    {
        /** @var User $user */
        $user = $this->auth->user();

        $topic->unsubscribe($user);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
