<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user()
            ? UserResource::make($request->user())
            : null;

        return [
            ...parent::share($request),

            'app' => [
                'name' => config('app.name'),
            ],

            'auth' => [
                'user' => $user,
            ],

            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
