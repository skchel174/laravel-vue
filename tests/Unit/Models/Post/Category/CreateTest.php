<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Post\Category;

use App\Casts\Title;
use App\Models\Post\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyCreate(): void
    {
        $faker = $this->getFaker();

        $category = Category::create($title = Title::create($faker->sentence(1)));

        $this->assertInstanceOf(Category::class, $category);
        $this->assertModelExists($category);
        $this->assertIsInt($category->id);
        $this->assertEquals($category->title, $title);
    }
}
