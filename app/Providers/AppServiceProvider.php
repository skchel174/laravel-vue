<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\TopicRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TopicRepositoryInterface::class, TopicRepository::class);
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
