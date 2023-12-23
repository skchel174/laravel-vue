<?php

declare(strict_types=1);

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use App\Models\Comment\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Comment $resource
 */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'author' => UserResource::make($this->resource->author),
            'is_liked' => $this->resource->is_liked,
            'likes_count' => $this->resource->likes_count ?? 28,
            'is_bookmarked' => $this->resource->is_bookmarked,
            'created_date' => $this->resource->created_at->format('d-m-Y H:i'),
            'comments' => CommentResource::collection($this->resource->comments),
            'total_comments' => $this->resource->getTotalCommentsCount(),
        ];
    }
}
