<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Topic\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TopicsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getCategories() as $category => $topics) {
            $category = Category::factory()->create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);

            foreach ($topics as $topic => $icon) {
                Topic::factory()->create([
                    'name' => $topic,
                    'slug' => Str::slug($topic),
                    'icon' => 'topic/' . $icon,
                    'category_id' => $category,
                ]);
            }
        }
    }

    public function getCategories(): array
    {
        return [
            'Development' => [
                'Programming' => 'programming.png',
                'Information security' => 'information-security.png',
                'Machine learning' => 'machine-learning.png',
                'Game development' => 'game-development.png',
                'Algorithms' => 'algorithms.png',
            ],

            'Admin' => [
                'Network technologies' => 'network-technologies.png',
                'Configuring Linux' => 'configuring-linux.png',
                'DevOps' => 'devops.png',
                'Server administration' => 'server-administration.png',
                'Database administration' => 'database-administration.png',
            ],

            'Design' => [
                'Graphic design' => 'graphic-design.png',
                'Web design' => 'web-design.png',
                'Game design' => 'game-design.png',
                'Typography' => 'typography.png',
            ],

            'Management' => [
                'IT-companies' => 'it-companies.png',
                'Project management' => 'project-management.png',
                'Product management' => 'product-management.png',
                'Business models' => 'business-models.png',
                'Freelance' => 'freelance.png',
                'Agile' => 'agile.png',
            ],

            'Marketing' => [
                'Web analytics' => 'web-analytics.png',
                'Content marketing' => 'content-analytics.png',
                'Branding' => 'branding.png',
                'IT systems monetization' => 'it-monetization.png',
            ],

            'PopSci' => [
                'Old hardware' => 'old-hardware.png',
                'History of IT' => 'it-history.png',
                'Software' => 'software.png',
                'CPU' => 'cpu.png',
                'Games and game consoles' => 'games.png',
            ],
        ];
    }
}
