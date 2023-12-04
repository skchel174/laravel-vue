<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Category;

use App\Models\Category\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateNewTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewCategory(): void
    {
        $category = Category::createNew($name = $this->faker->word());

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($name, $category->name);
        $this->assertEquals(Str::slug($name), $category->slug);
        $this->assertTrue($category->exists());
    }
}
