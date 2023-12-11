<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Category\Category;
use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();

        foreach ($this->getCategories() as $category => $topics) {
            $category = Category::factory()->create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);

            foreach ($topics as $topic) {
                $subscribers = $users->random(rand(1, $users->count()));
                $topicArticles = $articles->random(rand(10, 30));

                Topic::factory()
                    ->withIcon($topic['icon'])
                    ->hasAttached($topicArticles)
                    ->hasAttached($subscribers, relationship: 'subscribers')
                    ->create([
                        'name' => $topic['name'],
                        'slug' => Str::slug($topic['name']),
                        'category_id' => $category,
                    ]);
            }
        }

        $articles = Article::query()
            ->leftJoin('article_topic', 'articles.id', '=', 'article_topic.article_id')
            ->whereNull('article_topic.article_id')
            ->get();

        if ($articles->isNotEmpty()) {
            /** @var Topic $topic */
            $topic = Topic::find(1);
            $topic->articles()->attach($articles);
        }
    }

    public function getCategories(): array
    {
        return [
            'Development' => [
                ['name' => 'Programming', 'icon' => 'programming.png'],
                ['name' => 'Information security', 'icon' => 'information-security.png'],
                ['name' => 'Machine learning', 'icon' => 'machine-learning.png'],
                ['name' => 'Game development', 'icon' => 'game-development.png'],
                ['name' => 'Algorithms', 'icon' => 'algorithms.png'],
            ],

            'Admin' => [
                ['name' => 'Network technologies', 'icon' => 'network-technologies.png'],
                ['name' => 'Configuring Linux', 'icon' => 'configuring-linux.png'],
                ['name' => 'DevOps', 'icon' => 'devops.png'],
                ['name' => 'Server administration', 'icon' => 'server-administration.png'],
                ['name' => 'Database administration', 'icon' => 'database-administration.png'],
            ],

            'Design' => [
                ['name' => 'Graphic design', 'icon' => 'graphic-design.png'],
                ['name' => 'Web design', 'icon' => 'web-design.png'],
                ['name' => 'Game design', 'icon' => 'game-design.png'],
                ['name' => 'Typography', 'icon' => 'typography.png'],
            ],

            'Management' => [
                ['name' => 'IT-companies', 'icon' => 'it-companies.png'],
                ['name' => 'Project management', 'icon' => 'project-management.png'],
                ['name' => 'Product management', 'icon' => 'product-management.png'],
                ['name' => 'Business models', 'icon' => 'business-models.png'],
                ['name' => 'Freelance', 'icon' => 'freelance.png'],
                ['name' => 'Agile', 'icon' => 'agile.png'],
            ],

            'Marketing' => [
                ['name' => 'Web analytics', 'icon' => 'web-analytics.png'],
                ['name' => 'Content marketing', 'icon' => 'content-analytics.png'],
                ['name' => 'Branding', 'icon' => 'branding.png'],
                ['name' => 'IT systems monetization', 'icon' => 'it-monetization.png'],
            ],

            'PopSci' => [
                ['name' => 'Old hardware', 'icon' => 'old-hardware.png'],
                ['name' => 'History of IT', 'icon' => 'it-history.png'],
                ['name' => 'Software', 'icon' => 'software.png'],
                ['name' => 'CPU', 'icon' => 'cpu.png'],
                ['name' => 'Games and game consoles', 'icon' => 'games.png'],
            ],
        ];
    }
}
