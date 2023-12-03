<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Topic\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getCategories() as $category => $topics) {
            $category = Category::factory()->create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);

            foreach ($topics as $topic) {
                Topic::factory()->create([
                    'name' => $topic,
                    'slug' => Str::slug($topic),
                    'category_id' => $category,
                ]);
            }
        }
    }

    public function getCategories(): array
    {
        return [
            'Development' => [
                'Programming', 'Information security', 'Machine learning', 'Game development', 'Algorithms',
            ],

            'Admin' => [
                'Network technologies', 'Configuring Linux', 'DevOps', 'Server administration', 'Database administration',
            ],

            'Design' => [
                'Graphic design', 'Web design', 'Game design', 'Typography',
            ],

            'Management' => [
                'IT-companies', 'Project management', 'Product management', 'Business models', 'Freelance', 'Agile',
            ],

            'Marketing' => [
                'Web analytics', 'Content marketing', 'Branding', 'IT systems monetization',
            ],

            'PopSci' => [
                'Old hardware', 'History of IT', 'Software', 'CPU', 'Games and game consoles',
            ],
        ];
    }
}
