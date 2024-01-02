<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Topics;

use App\Http\Controllers\Controller;
use App\Models\Topic\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function make(Topic $topic): JsonResponse
    {
        $topic->subscribe(Auth::user());

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Topic $topic): JsonResponse
    {
        $topic->unsubscribe(Auth::user());

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
