<?php

declare(strict_types=1);

namespace App\Http\Resources\Article;

use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Article $resource
 */
class ArticleCardResource extends JsonResource
{
    public function __construct(Article $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'status' => $this->resource->status->value,
            'difficulty' => $this->resource->difficulty?->value,
            'summary' => $this->resource->summary,
            'views' => $this->resource->views,
            'is_bookmarked' => $this->resource->is_bookmarked,
            'is_liked' => $this->resource->is_liked,
            'likes_count' => $this->resource->likes_count,
            'comments_count' => $this->resource->related_comments_count,
            'image' => $this->resource->feed_image?->getUrl(),
            'publish_date' => $this->resource->published_at?->format('d-m-Y H:i'),
            'author' => UserResource::make($this->resource->author),
            'topics' => TopicResource::collection($this->resource->topics),
        ];
    }
}
