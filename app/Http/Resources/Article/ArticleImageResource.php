<?php

declare(strict_types=1);

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Media $resource
 */
class ArticleImageResource extends JsonResource
{
    public function __construct(Media $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'xl' => $this->resource->getUrl(),
            'md' => $this->resource->getUrl('md'),
        ];
    }
}
