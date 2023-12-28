<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Comment\Comment;
use App\Policies\CommentPolicy;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Comment::class => CommentPolicy::class,
    ];

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        parent::register();

        $this->app->bind(StatefulGuard::class, function () {
            $manager = $this->app->get(AuthManager::class);
            return $manager->guard();
        });
    }
}
