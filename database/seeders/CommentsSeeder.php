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
            foreach ($users->random(rand(0, 5)) as $user) {
                Comment::factory()
                    ->withAuthor($user)
                    ->forArticle($article)
                    ->hasAttached($users->random(rand(0, 2)), relationship: 'bookmarks')
                    ->create();
            }
        }
    }
}
