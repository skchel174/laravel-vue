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

    public function forArticle(Article $article): CommentFactory
    {
        return $this->state([
            'article_id' => $article->id,
            'created_at' => $this->faker->dateTimeBetween($article->created_at),
        ])->for($article, 'commentable');
    }

    public function forComment(Comment $comment): CommentFactory
    {
        return $this->state([
            'depth' => $comment->depth + 1,
            'article_id' => Article::factory(),
            'created_at' => $this->faker->dateTimeBetween($comment->created_at),
        ])->for($comment, 'commentable');
    }

    public function bookmarkedBy(User $user): CommentFactory
    {
        return $this->hasAttached($user, relationship: 'usersBookmarked');
    }
}
