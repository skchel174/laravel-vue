<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function __construct(private readonly CategoryRepositoryInterface $categories)
    {
    }

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
        $categories = CategoryResource::collection($this->categories->getAll());

        $user = $request->user()
            ? UserResource::make($request->user())
            : null;

        return [
            ...parent::share($request),

            'app' => [
                'name' => config('app.name'),
                'categories' => $categories,
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
