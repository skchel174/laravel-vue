<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Models\User\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Contact $resource
 */
class UserContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'url' => $this->resource->getUrl(),
            'value' => $this->resource->value,
            'contact_type_id' => $this->resource->contactType->id,
            'name' => $this->resource->contactType->name,
            'icon' => $this->resource->contactType->getIcon(),
        ];
    }
}
