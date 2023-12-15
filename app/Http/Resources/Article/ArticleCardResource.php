<?php

declare(strict_types=1);

namespace App\Http\Resources\Article;

use App\Http\Resources\Topic\TopicResource;
use App\Http\Resources\User\UserResource;
use App\Models\Article\Article;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Article $resource
 */
class ArticleCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $image = $this->resource->getCardImage()
            ? ArticleImageResource::make($this->resource->getCardImage())
            : null;

        $publishedDate = $this->resource->published_at
            ? $this->formatDate($this->resource->published_at)
            : null;

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'status' => $this->resource->status->value,
            'difficulty' => $this->resource->difficulty?->value,
            'summary' => $this->resource->summary,
            'views' => $this->resource->views,
            'is_bookmarked' => false,
            'likes_count' => rand(0, 5000),
            'comments_count' => rand(0, 100),
            'image' => $image,
            'publish_date' => $publishedDate,
            'created_date' => $this->formatDate($this->resource->created_at),
            'author' => UserResource::make($this->resource->author),
            'topics' => TopicResource::collection($this->resource->topics),
        ];
    }

    private function formatDate(CarbonImmutable $date): string
    {
        return $date->format('d-m-Y H:i');
    }
}
