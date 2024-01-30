<?php

declare(strict_types=1);

namespace App\Http\Resources\Tag;

use App\Models\Tag\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Tag $resource
 */
class TagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'slug' => $this->resource->slug,
            'name' => $this->resource->getLocalizedValue('name'),
        ];
    }
}
