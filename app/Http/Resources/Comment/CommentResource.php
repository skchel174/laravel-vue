<?php

declare(strict_types=1);

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use App\Models\Comment\Comment;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Comment $resource
 */
class CommentResource extends JsonResource
{
    public function __construct(Comment $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'author' => UserResource::make($this->resource->author),
            'is_editable' => $this->resource->isEditable(CarbonImmutable::now()),
            'created_date' => $this->resource->created_at->format('d-m-Y H:i'),
            'comments' => CommentResource::collection($this->resource->comments),
            'total_comments' => $this->resource->getCommentsCount(),
            'is_bookmarked' => (bool) $this->resource->is_bookmarked,
            'article_id' => $this->resource->article_id,
        ];
    }
}
