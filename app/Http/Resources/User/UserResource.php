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
        $avatar = $this->resource->getAvatar();

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'about' => $this->resource->about,
            'email' => $this->resource->email,
            'status' => $this->resource->status->value,
            'login_at' => $this->resource->login_at->format('d-m-Y H:i'),
            'created_at' => $this->resource->created_at->format('d M Y'),
            'avatar' => $avatar ? AvatarResource::make($avatar)->toArray($request) : null,
        ];
    }
}
