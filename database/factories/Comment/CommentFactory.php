<?php

declare(strict_types=1);

namespace Database\Factories\Comment;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'text' => $this->faker->text(),
        ];
    }

    public function withAuthor(User $user): CommentFactory
    {
        return $this->state([
            'author_id' => $user,
        ]);
    }

    public function forCommentable(Article|Comment $commentable): CommentFactory
    {
        $this->state([
           'created_at' => $this->faker->dateTimeBetween($commentable->created_at),
        ]);

        return $this->for($commentable, 'commentable');
    }
}
