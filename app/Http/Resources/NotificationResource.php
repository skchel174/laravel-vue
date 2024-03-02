<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Notification $resource
 */
class NotificationResource extends JsonResource
{
    public function __construct(Notification $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource->type,
            'message' => $this->resource->message,
        ];
    }
}
