<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Tag\Tag;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        /** @var Collection<User> $users */
        $users = User::get();

        $topics = Topic::get();

        $tags = Tag::get();

        foreach ($users as $user) {
            Article::factory(30)
                ->hasAttached($topics->random(rand(1, 3)))
                ->hasAttached($tags->random(rand(1, 10)))
                ->create(['author_id' => $user]);
        }
    }
}
