<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property-read LengthAwarePaginator $resource
 */
class UsersCollection extends JsonResource
{
    public function __construct(LengthAwarePaginator $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'items' => UserResource::collection($this->resource->items()),
            'totalPages' => ceil($this->resource->total() / $this->resource->perPage()),
            'currentPage' => $this->resource->currentPage(),
            'perPage' => $this->resource->perPage(),
            'path' => $this->resource->path(),
            'options' => $request->query(),
        ];
    }
}
