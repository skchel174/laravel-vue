<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();

        foreach ($articles as $article) {
            $randomUsers = $users->random(rand(1, $users->count() / 2));

            foreach ($randomUsers as $user) {
                Comment::factory()
                    ->withAuthor($user)
                    ->forArticle($article)
                    ->create();
            }
        }
    }
}
