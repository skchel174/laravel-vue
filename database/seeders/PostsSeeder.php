<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post\Category;
use App\Models\Post\Channel;
use App\Models\Post\Post;
use Database\Factories\Post\PostFactory;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->get();

        Channel::query()->each(function (Channel $channel) use ($categories) {
            for ($i = 0; $i < rand(5, 10); $i++) {
                /** @var PostFactory $factory */
                $factory = Post::factory();
                $factory->withChannel($channel)
                    ->withCategories($categories->random(rand(1, 3)))
                    ->create();
            }
        });
    }
}
