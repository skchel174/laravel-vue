<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function make(User $user): JsonResponse
    {
        Auth::user()->follow($user);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function remove(User $user): JsonResponse
    {
        Auth::user()->unfollow($user);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
