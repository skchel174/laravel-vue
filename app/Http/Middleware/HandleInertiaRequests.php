<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\User\UserResource;
use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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

            'locale' => App::getLocale(),
            'langs' => Session::get('langs', [App::getLocale()]),
            'view' => Session::get('view', 'classic'),

            'app' => [
                'name' => config('app.name'),
            ],

            'auth' => [
                'user' => $request->user()
                    ? UserResource::make($request->user())
                    : null,
            ],

            'nav_location' => null,

            'nav_items' => $this->getNavItems(),

            'categories' => fn() => CategoryResource::collection(Category::all()),

            'trans' => fn() => trans('components'),

            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }

    private function getNavItems(): array
    {
        return [
            [
                'id' => 'feed',
                'title' => 'My feed',
                'url' => route('articles.feed'),
            ],

            [
                'id' => 'articles',
                'title' => 'All categories',
                'url' => route('articles'),
            ],

            ...Category::all()->map(fn(Category $category) => [
                'id' => $category->slug,
                'title' => $category->getLocalizedValue('name'),
                'url' => route('category.articles', ['category' => $category->slug]),
            ]),
        ];
    }
}
