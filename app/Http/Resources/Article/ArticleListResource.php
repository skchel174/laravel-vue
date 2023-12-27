<?php

declare(strict_types=1);

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property LengthAwarePaginator $resource
 */
class ArticleListResource extends JsonResource
{
    public function __construct(LengthAwarePaginator $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        $query = array_filter(
            $request->query(),
            fn (string $key) => $key !== $this->resource->getPageName(),
        ARRAY_FILTER_USE_KEY,
        );

        return [
            'query' => $query,
            'perPage' => $this->resource->perPage(),
            'currentPage' => $this->resource->currentPage(),
            'totalPages' => ceil($this->resource->total() / $this->resource->perPage()),
            'items' => ArticleCardResource::collection($this->resource->items()),
        ];
    }
}
