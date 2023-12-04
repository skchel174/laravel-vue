<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SetCardImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testSetCardImage(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $article->setCardImage(UploadedFile::fake()->image('image.jpg'));

        $this->assertNotEmpty($article->getMedia('card_image'));

        $media = $article->getFirstMedia('card_image');
        $this->assertEquals('image', $media->name);
        Storage::disk('public')->assertExists($media->getPathRelativeToRoot());
    }
}
