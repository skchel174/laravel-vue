<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tag\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory(100)->create();
    }
}
