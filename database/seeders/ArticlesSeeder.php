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
            $userTags = $tags->random(rand(10, 20));
            $userTopics = $topics->random(rand(1, 10));

            for ($i = 0; $i < rand(0, 20); $i++) {
                Article::factory()
                    ->hasAttached($userTags->random(rand(5, $userTags->count())))
                    ->hasAttached($userTopics->random(rand(1, $userTopics->count())))
                    ->hasAttached($users->random(rand(0, $user->count())), relationship: 'likes')
                    ->hasAttached($users->random(rand(0, 5)), relationship: 'bookmarks')
                    ->create([
                        'author_id' => $user,
                        'difficulty' => fn() => Collection::make([null, ...Difficulty::cases()])->random(),
                    ]);
            }
        }
    }
}
