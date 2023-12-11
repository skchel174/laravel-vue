<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Topics;

use App\Http\Controllers\Controller;
use App\Models\Topic\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function make(Request $request, Topic $topic): JsonResponse
    {
        $topic->subscribe($request->user());

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(Request $request, Topic $topic): JsonResponse
    {
        $topic->unsubscribe($request->user());

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
