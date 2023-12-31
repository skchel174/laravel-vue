<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\User\UserResource;
use App\Models\Category\Category;
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
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            'app' => [
                'name' => config('app.name'),
                'categories' => CategoryResource::collection(Category::all()),
            ],

            'auth' => [
                'user' => $request->user() ? UserResource::make($request->user()) : null,
            ],

            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
