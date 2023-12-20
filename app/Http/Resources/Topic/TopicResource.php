<?php

declare(strict_types=1);

namespace App\Http\Resources\Topic;

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
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'description' => $this->resource->description,
            'subscribers_count' => $this->resource->subscribers_count,
            'articles_count' => $this->resource->articles_count,
            'icon' => asset(sprintf('storage/%s', $this->resource->icon)),
        ];
    }
}
