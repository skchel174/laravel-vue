<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Comment::class => CommentPolicy::class,
        Article::class => ArticlePolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
