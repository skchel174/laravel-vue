<?php

declare(strict_types=1);

namespace App\Http\Resources\Article;

use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Article;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Article $resource
 */
class ArticleResource extends JsonResource
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
            'text' => $this->resource->text,
            'views' => $this->resource->views,
            'is_bookmarked' => (bool) $this->resource->is_bookmarked,
            'is_liked' => (bool) $this->resource->is_liked,
            'likes_count' => (int) $this->resource->likes_count,
            'comments_count' => (int) $this->resource->related_comments_count,
            'media_id' => $this->resource->article_media_id,
            'image' => $this->resource->feed_image?->getUrl(),
            'publish_date' => $this->getPublishDate(),
            'created_date' => $this->formatDate($this->resource->created_at),
            'author' => UserResource::make($this->resource->author),
            'topics' => TopicResource::collection($this->resource->topics),
            'tags' => TagResource::collection($this->resource->tags),
        ];
    }

    private function getPublishDate(): ?string
    {
        if ($this->resource->published_at) {
            return $this->formatDate($this->resource->published_at);
        }

        return null;
    }

    private function formatDate(CarbonImmutable $date): string
    {
        return $date->format('d-m-Y H:i');
    }
}
