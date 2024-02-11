<?php

declare(strict_types=1);

namespace App\Http\Resources\Topic;

use App\Http\Resources\Tag\TagResource;
use App\Models\Topic\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Topic $resource
 */
class TopicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tags = $this->resource->relationLoaded('tags')
            ? TagResource::collection($this->resource->tags)
            : [];

        return [
            'id' => $this->resource->id,
            'slug' => $this->resource->slug,
            'name' => $this->resource->getLocalizedValue('name'),
            'description' => $this->resource->getLocalizedValue('description'),
            'subscribers_count' => $this->resource->subscribers_count,
            'articles_count' => $this->resource->articles_count,
            'is_subscribed' => (bool) $this->resource->is_subscribed,
            'icon' => asset(sprintf('storage/%s', $this->resource->icon)),
            'tags' => $tags,
        ];
    }
}
