<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article\ArticleMedia;

use App\Models\Article\ArticleMedia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddImageTest extends TestCase
{
    use RefreshDatabase;

    public function testAddImageForArticleStub(): void
    {
        Storage::fake('public');

        /** @var ArticleMedia $stub */
        $stub = ArticleMedia::factory()->create();

        $stub->addImage(UploadedFile::fake()->image('test.jpg'));

        $this->assertNotEmpty($stub->getMedia('images'));
    }
}
