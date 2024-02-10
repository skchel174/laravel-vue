<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Article\Difficulty;
use App\Models\Tag\Tag;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();
        $topics = Topic::all();
        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(0, 20); $i++) {
                $articleTags = $tags->random(rand(10, 20));
                $articleTopics = $topics->random(rand(5, 10));

                Article::factory()
                    ->hasAttached($articleTags->random(rand(5, 10)))
                    ->hasAttached($articleTopics->random(rand(1, 5)))
                    ->hasAttached($users->random(rand(0, $user->count())), relationship: 'likes')
                    ->hasAttached($users->random(rand(0, 5)), relationship: 'bookmarks')
                    ->create(['author_id' => $user]);
            }
        }
    }
}
