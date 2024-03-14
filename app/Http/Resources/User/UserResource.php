<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read User $resource
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'fullname' => $this->resource->fullname,
            'about' => $this->resource->about,
            'email' => $this->resource->email,
            'status' => $this->resource->status->value,
            'gender' => $this->resource->gender,
            'birthday' => $this->resource->birthday?->format('d-m-Y'),
            'login_at' => $this->resource->login_at->format('d-m-Y H:i'),
            'created_at' => $this->resource->created_at->format('d-m-Y H:i'),
            'avatar' => $this->resource->avatar?->getUrl(),
            'articles_count' => $this->resource->articles_count ?? null,
        ];
    }
}
