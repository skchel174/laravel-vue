<?php

declare(strict_types=1);

namespace Database\Factories\Article;

use App\Models\Article\ArticleMedia;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleMediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
        ];
    }

    public function withAuthor(User $user): ArticleMediaFactory
    {
        return $this->afterMaking(function (ArticleMedia $stub) use ($user) {
           $stub->author()->associate($user);
        });
    }
}
