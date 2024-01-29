<?php

declare(strict_types=1);

namespace App\Http\Resources\Category;

use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Category $resource
 */
class CategoryResource extends JsonResource
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
