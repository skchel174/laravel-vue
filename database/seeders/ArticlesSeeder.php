<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Article\Difficulty;
use App\Models\Tag\Tag;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $tags = Tag::all();

        foreach ($users as $user) {
            Article::factory(rand(10, 50))
                ->hasAttached($tags->random(rand(1, 10)))
                ->create([
                    'author_id' => $user,
                    'difficulty' => fn() => Collection::make([null, ...Difficulty::cases()])->random(),
                ]);
        }

        $articles = Article::all();

        foreach ($users as $user) {
            /** @var User $user */
            $user->bookmarkedArticles()
                ->attach($articles->random(rand(5, 20)));

            $user->likedArticles()
                ->attach($articles->random(rand(10, $articles->count())));
        }
    }
}
