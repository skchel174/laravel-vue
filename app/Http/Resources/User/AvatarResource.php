<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Media|null $resource
 */
class AvatarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'xl' => $this->resource->getUrl(),
            'md' => $this->resource->getUrl('md'),
            'sm' => $this->resource->getUrl('sm'),
        ];
    }
}
