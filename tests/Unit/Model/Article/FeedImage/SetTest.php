<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article\FeedImage;

use App\Models\Article\Article;
use App\Models\Article\FeedImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SetTest extends TestCase
{
    use RefreshDatabase;

    public function testSetFeedImageForArticle(): void
    {
        Storage::fake('public');

        /** @var Article $article */
        $article = Article::factory()->create([
            'feed_image' => null,
        ]);

        $article->update(['feed_image' => FeedImage::create(UploadedFile::fake()->image('demo.jpg'))]);
        $article->refresh();

        $this->assertInstanceOf(FeedImage::class, $article->feed_image);
        $this->assertFileExists($article->feed_image->getFile());
    }

    public function testChangeArticleFeedImage(): void
    {
        Storage::fake('public');

        /** @var Article $article */
        $article = Article::factory()->create([
            'feed_image' => $oldImage = FeedImage::create(UploadedFile::fake()->image('demo.jpg')),
        ]);

        $article->update(['feed_image' => FeedImage::create(UploadedFile::fake()->image('demo.jpg'))]);
        $article->refresh();

        $this->assertNotEquals($oldImage->getFile(), $article->feed_image->getFile());
        $this->assertFileExists($article->feed_image->getFile());
        $this->assertFileDoesNotExist($oldImage->getFile());
    }

    public function testDeleteAvatar(): void
    {
        Storage::fake('public');

        /** @var Article $article */
        $article = Article::factory()->create([
            'feed_image' => $oldImage = FeedImage::create(UploadedFile::fake()->image('demo.jpg')),
        ]);

        $article->update(['feed_image' => null]);

        $this->assertNull($article->feed_image);
        $this->assertFileDoesNotExist($oldImage->getFile());
    }
}
