<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\AddImageRequest;
use App\Http\Resources\Article\ArticleImageResource;
use App\Models\Article\ArticleMedia;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MediaController extends Controller
{
    public function create(): JsonResponse
    {
        $media = ArticleMedia::createNew(Auth::user());

        return response()->json(['media' => $media->id]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws AuthorizationException
     */
    public function addImage(AddImageRequest $request, ArticleMedia $media): JsonResponse
    {
        if ($media->article) {
            $this->authorize('update', $media->article);
        }

        $image = $media->addImage($request->image);

        return response()->json([
            'image' => ArticleImageResource::make($image),
        ]);
    }
}
