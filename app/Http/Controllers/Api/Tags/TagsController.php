<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Tags;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag\Tag;
use Illuminate\Http\JsonResponse;

class TagsController extends Controller
{
    public function search(string $name): JsonResponse
    {
        $tags = Tag::where('name', 'like', "$name%")
            ->limit(10)
            ->get();

        return response()->json([
            'tags' => TagResource::collection($tags),
        ]);
    }
}
