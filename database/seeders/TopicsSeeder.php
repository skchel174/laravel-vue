<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Localization\Locale;
use App\Models\Tag\Tag;
use App\Models\Topic\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TopicsSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();

        foreach ($this->getCategories() as $category => $categoryProps) {
            $category = Category::factory()
                ->withLocalization(Locale::Ru, $categoryProps['localization'])
                ->create([
                    'name' => $category,
                    'slug' => Str::slug($category),
                ]);

            foreach ($categoryProps['topics'] as $topic => $topicProps) {
                Topic::factory()
                    ->withtags($tags->random(rand(0, 20)))
                    ->withLocalization(Locale::Ru, $topicProps['localization'])
                    ->create([
                        'name' => $topic,
                        'slug' => Str::slug($topic),
                        'icon' => 'topic/' . $topicProps['icon'],
                        'category_id' => $category,
                    ]);
            }
        }
    }

    public function getCategories(): array
    {
        return [
            'Development' => [
                'localization' => ['name' => 'Разработка'],
                'topics' => [
                    'Programming' => [
                        'icon' => 'programming.png',
                        'localization' => ['name' => 'Программирование'],
                    ],
                    'Information security' => [
                        'icon' => 'information-security.png',
                        'localization' => ['name' => 'Информационная безопасность'],
                    ],
                    'Machine learning' => [
                        'icon' => 'machine-learning.png',
                        'localization' => ['name' => 'Машинное обучение'],
                    ],
                    'Game development' => [
                        'icon' => 'game-development.png',
                        'localization' => ['name' => 'Разработка игр'],
                    ],
                    'Algorithms' => [
                        'icon' => 'algorithms.png',
                        'localization' => ['name' => 'Алгоритмы'],
                    ],
                ],
            ],

            'Admin' => [
                'localization' => ['name' => 'Администрирование'],
                'topics' => [
                    'Network technologies' => [
                        'localization' => ['name' => 'Сетевые технологии'],
                        'icon' => 'network-technologies.png',
                    ],
                    'Configuring Linux' => [
                        'localization' => ['name' => 'Настройка Linux'],
                        'icon' => 'configuring-linux.png',
                    ],
                    'DevOps' => [
                        'localization' => ['name' => 'DevOps'],
                        'icon' => 'devops.png',
                    ],
                    'Server administration' => [
                        'localization' => ['name' => 'Серверное администрирование'],
                        'icon' => 'server-administration.png',
                    ],
                    'Database administration' => [
                        'localization' => ['name' => 'Администрирование баз данных'],
                        'icon' => 'database-administration.png',
                    ],
                ],
            ],

            'Design' => [
                'localization' => ['name' => 'Дизайн'],
                'topics' => [
                    'Graphic design' => [
                        'localization' => ['name' => 'Графический дизайн'],
                        'icon' => 'graphic-design.png',
                    ],
                    'Web design' => [
                        'localization' => ['name' => 'Веб-дизайн'],
                        'icon' => 'web-design.png',
                    ],
                    'Game design' => [
                        'localization' => ['name' => 'Дизайн игр'],
                        'icon' => 'game-design.png',
                    ],
                    'Typography' => [
                        'localization' => ['name' => 'Типографика'],
                        'icon' => 'typography.png',
                    ],
                ],
            ],

            'Management' => [
                'localization' => ['name' => 'Менеджмент'],
                'topics' => [
                    'IT-companies' => [
                        'localization' => ['name' => 'IT-компании'],
                        'icon' => 'it-companies.png',
                    ],
                    'Project management' => [
                        'localization' => ['name' => 'Управление проектами'],
                        'icon' => 'project-management.png',
                    ],
                    'Product management' => [
                        'localization' => ['name' => 'Управление продуктом'],
                        'icon' => 'product-management.png',
                    ],
                    'Business models' => [
                        'localization' => ['name' => 'Бизнес-модели'],
                        'icon' => 'business-models.png',
                    ],
                    'Freelance' => [
                        'localization' => ['name' => 'Фриланс'],
                        'icon' => 'freelance.png',
                    ],
                    'Agile' => [
                        'localization' => ['name' => 'Agile'],
                        'icon' => 'agile.png',
                    ],
                ],
            ],

            'Marketing' => [
                'localization' => ['name' => 'Маркетинг'],
                'topics' => [
                    'Web analytics' => [
                        'localization' => ['name' => 'Веб-аналитика'],
                        'icon' => 'web-analytics.png',
                    ],
                    'Content marketing' => [
                        'localization' => ['name' => 'Контент-маркетинг'],
                        'icon' => 'content-analytics.png',
                    ],
                    'Branding' => [
                        'localization' => ['name' => 'Брендинг'],
                        'icon' => 'branding.png',
                    ],
                    'IT systems monetization' => [
                        'localization' => ['name' => 'Монетизация IT-систем'],
                        'icon' => 'it-monetization.png',
                    ],
                ],
            ],

            'PopSci' => [
                'localization' => ['name' => 'Научпоп'],
                'topics' => [
                    'Old hardware' => [
                        'localization' => ['name' => 'Старое железо'],
                        'icon' => 'old-hardware.png',
                    ],
                    'History of IT' => [
                        'localization' => ['name' => 'История IT'],
                        'icon' => 'it-history.png',
                    ],
                    'Software' => [
                        'localization' => ['name' => 'Софт'],
                        'icon' => 'software.png',
                    ],
                    'CPU' => [
                        'localization' => ['name' => 'Процессоры'],
                        'icon' => 'cpu.png',
                    ],
                    'Games and game consoles' => [
                        'localization' => ['name' => 'Игры и игровые консоли'],
                        'icon' => 'games.png',
                    ],
                ],
            ],
        ];
    }
}
